const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

function refreshIcons() {
    if (window.lucide?.createIcons) {
        window.lucide.createIcons({ attrs: { 'stroke-width': 1.8 } });
    }
}

function toggleHidden(element, force) {
    if (!element) return;
    element.classList.toggle('hidden', force ?? !element.classList.contains('hidden'));
}

document.addEventListener('DOMContentLoaded', () => {
    refreshIcons();

    // Public mobile navigation
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    mobileMenuButton?.addEventListener('click', () => {
        const menu = document.getElementById('mobile-menu');
        const isOpen = menu && !menu.classList.contains('hidden');
        toggleHidden(menu, isOpen);
        mobileMenuButton.setAttribute('aria-expanded', String(!isOpen));
    });

    // Admin sidebar
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    const closeSidebar = () => {
        sidebar?.classList.add('-translate-x-full');
        toggleHidden(sidebarOverlay, true);
    };

    document.getElementById('sidebar-toggle')?.addEventListener('click', () => {
        sidebar?.classList.remove('-translate-x-full');
        toggleHidden(sidebarOverlay, false);
    });
    sidebarOverlay?.addEventListener('click', closeSidebar);

    // User dropdown
    const userMenuButton = document.getElementById('user-menu-button');
    userMenuButton?.addEventListener('click', (event) => {
        event.stopPropagation();
        const menu = document.getElementById('user-menu');
        const isOpen = menu && !menu.classList.contains('hidden');
        toggleHidden(menu, isOpen);
        userMenuButton.setAttribute('aria-expanded', String(!isOpen));
    });
    document.addEventListener('click', (event) => {
        if (!event.target.closest('#user-menu-button, #user-menu')) {
            toggleHidden(document.getElementById('user-menu'), true);
        }
    });

    // Dismissible alerts
    document.querySelectorAll('.alert-close').forEach((button) => {
        button.addEventListener('click', () => button.closest('[data-alert]')?.remove());
    });

    // Delete confirmations
    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (!window.confirm(form.dataset.confirm || 'Yakin ingin melanjutkan?')) {
                event.preventDefault();
            }
        });
    });

    // Single image preview
    document.querySelectorAll('input[data-image-preview]').forEach((input) => {
        input.addEventListener('change', () => {
            const preview = document.getElementById(input.dataset.imagePreview);
            const file = input.files?.[0];
            if (!preview || !file) return;

            if (preview.dataset.objectUrl) URL.revokeObjectURL(preview.dataset.objectUrl);
            const url = URL.createObjectURL(file);
            preview.dataset.objectUrl = url;
            preview.src = url;
            preview.classList.remove('hidden');
            const wrapper = preview.closest('[data-preview-wrapper]')
                ?? preview.parentElement?.querySelector('[data-preview-wrapper]');
            wrapper?.classList.add('hidden');
        });
    });

    // Multiple image previews
    document.querySelectorAll('input[data-multi-preview]').forEach((input) => {
        input.addEventListener('change', () => {
            const target = document.getElementById(input.dataset.multiPreview);
            if (!target) return;

            target.innerHTML = '';
            Array.from(input.files ?? []).slice(0, 20).forEach((file) => {
                const image = document.createElement('img');
                image.src = URL.createObjectURL(file);
                image.alt = file.name;
                image.className = 'size-20 rounded-lg border border-slate-200 object-cover';
                target.appendChild(image);
            });
            toggleHidden(target, (input.files?.length ?? 0) === 0);
        });
    });

    // Like / unlike
    document.querySelectorAll('button[data-like-url]').forEach(async (button) => {
        button.addEventListener('click', async () => {
            if (button.dataset.busy === '1') return;
            button.dataset.busy = '1';

            const liked = button.dataset.liked === '1';
            const url = liked ? button.dataset.unlikeUrl : button.dataset.likeUrl;

            try {
                const response = await fetch(url, {
                    method: liked ? 'DELETE' : 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        Accept: 'application/json',
                    },
                });

                if (!response.ok) throw new Error('Gagal memperbarui suka.');

                const data = await response.json();
                button.dataset.liked = data.liked ? '1' : '0';
                button.setAttribute('aria-pressed', String(data.liked));

                const icon = button.querySelector('i, svg');
                if (icon) {
                    icon.classList.toggle('fill-current', data.liked);
                    icon.classList.toggle('text-rose-600', data.liked);
                    icon.classList.toggle('text-slate-500', !data.liked);
                }

                const countTarget = document.getElementById(button.dataset.countTarget);
                if (countTarget) countTarget.textContent = data.likesCount;

                const label = button.querySelector('[data-like-label]');
                if (label) label.textContent = data.liked ? 'Suka' : 'Sukai';
            } catch (error) {
                window.alert(error.message);
            } finally {
                button.dataset.busy = '0';
                refreshIcons();
            }
        });
    });

    // Modals (report / lightbox)
    document.querySelectorAll('[data-open-modal]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            const modal = document.getElementById(trigger.dataset.openModal);
            if (!modal) return;

            if (trigger.dataset.modalFull) {
                const image = modal.querySelector('[data-modal-image]');
                const caption = modal.querySelector('[data-modal-caption]');
                if (image) image.src = trigger.dataset.modalFull;
                if (caption) caption.textContent = trigger.dataset.modalCaption || '';
            }

            if (trigger.dataset.modalAction) {
                const form = modal.querySelector('form');
                if (form) form.action = trigger.dataset.modalAction;
                const title = modal.querySelector('[data-modal-title]');
                if (title && trigger.dataset.modalTitle) title.textContent = trigger.dataset.modalTitle;
                const photo = modal.querySelector('[data-modal-photo]');
                if (photo && trigger.dataset.modalPhoto) photo.src = trigger.dataset.modalPhoto;
            }

            toggleHidden(modal, false);
            document.body.classList.add('overflow-hidden');
        });
    });

    document.querySelectorAll('[data-close-modal]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            const modal = trigger.closest('[data-modal]');
            toggleHidden(modal, true);
            document.body.classList.remove('overflow-hidden');
        });
    });
});

window.addEventListener('load', refreshIcons);
