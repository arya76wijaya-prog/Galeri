<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to modify each of these messages.
    |
    */

    'accepted'             => ':attribute harus diterima.',
    'accepted_if'          => ':attribute harus diterima ketika :other adalah :value.',
    'active_url'           => ':attribute bukan URL yang valid.',
    'after'                => ':attribute harus merupakan tanggal setelah :date.',
    'after_or_equal'       => ':attribute harus merupakan tanggal setelah atau sama dengan :date.',
    'alpha'                => ':attribute hanya boleh mengandung huruf.',
    'alpha_dash'           => ':attribute hanya boleh mengandung huruf, angka, dan tanda hubung.',
    'alpha_num'            => ':attribute hanya boleh mengandung huruf dan angka.',
    'array'                => ':attribute harus berupa array.',
    'attached'             => ':attribute tidak ditemukan.',
    'before'               => ':attribute harus merupakan tanggal sebelum :date.',
    'before_or_equal'      => ':attribute harus merupakan tanggal sebelum atau sama dengan :date.',
    'between'              => [
        'numeric' => ':attribute harus berada antara :min dan :max.',
        'file'    => ':attribute harus antara :min dan :max kilobyte.',
        'string'  => ':attribute harus antara :min dan :max karakter.',
        'array'   => ':attribute harus memiliki antara :min dan :max item.',
    ],
    'boolean'              => ':attribute harus bernilai benar atau salah.',
    'confirmed'            => ':attribute tidak cocok dengan konfirmasi.',
    'current_password'     => 'Kata sandi salah.',
    'date'                 => ':attribute bukan tanggal yang valid.',
    'date_equals'          => ':attribute harus sama dengan :date.',
    'date_format'          => ':attribute tidak cocok dengan format :format.',
    'decimal'              => ':attribute harus memiliki :places titik desimal.',
    'declined'             => ':attribute harus ditolak.',
    'declined_if'          => ':attribute harus ditolak ketika :other adalah :value.',
    'different'            => ':attribute dan :other harus berbeda.',
    'digits'               => ':attribute harus berupa :digits digit.',
    'digits_between'       => ':attribute harus antara :min dan :max digit.',
    'dimensions'           => ':attribute memiliki dimensi gambar yang tidak valid.',
    'distinct'             => ':attribute memiliki nilai duplikat.',
    'doesnt_start_with'    => ':attribute tidak boleh diawali dengan :values.',
    'email'                => ':attribute harus berupa alamat email yang valid.',
    'ends_with'            => ':attribute harus berakhir dengan salah satu dari: :values.',
    'enum'                 => ':attribute dipilih yang tidak valid.',
    'exists'               => ':attribute yang dipilih tidak valid.',
    'expires_at'           => ':attribute harus menjadi tanggal di masa depan.',
    'filled'               => ':attribute wajib diisi.',
    'file'                 => ':attribute harus berupa berkas.',
    'filled'               => ':attribute wajib diisi.',
    'gt'                   => [
        'numeric' => ':attribute harus lebih besar dari :value.',
        'file'    => ':attribute harus lebih besar dari :value kilobyte.',
        'string'  => ':attribute harus lebih panjang dari :value karakter.',
        'array'   => ':attribute harus memiliki lebih banyak dari :value item.',
    ],
    'gte'                  => [
        'numeric' => ':attribute harus lebih besar dari atau sama dengan :value.',
        'file'    => ':attribute harus lebih besar dari atau sama dengan :value kilobyte.',
        'string'  => ':attribute harus lebih panjang dari atau sama dengan :value karakter.',
        'array'   => ':attribute harus memiliki item lebih banyak dari atau sama dengan :value.',
    ],
    'image'                => ':attribute harus berupa berkas gambar.',
    'in'                   => ':attribute dipilih yang tidak valid.',
    'in_array'             => ':attribute tidak ada di :other.',
    'integer'              => ':attribute harus berupa bilangan bulat.',
    'ip'                   => ':attribute harus berupa alamat IP yang valid.',
    'ipv4'                 => ':attribute harus berupa alamat IPv4 yang valid.',
    'ipv6'                 => ':attribute harus berupa alamat IPv6 yang valid.',
    'json'                 => ':attribute harus berupa string JSON yang valid.',
    'lt'                   => [
        'numeric' => ':attribute harus lebih kecil dari :value.',
        'file'    => ':attribute harus lebih kecil dari :value kilobyte.',
        'string'  => ':attribute harus lebih pendek dari :value karakter.',
        'array'   => ':attribute harus memiliki lebih sedikit dari :value item.',
    ],
    'lte'                  => [
        'numeric' => ':attribute harus lebih kecil dari atau sama dengan :value.',
        'file'    => ':attribute harus lebih kecil dari atau sama dengan :value kilobyte.',
        'string'  => ':attribute harus lebih pendek dari atau sama dengan :value karakter.',
        'array'   => ':attribute harus memiliki item lebih sedikit dari atau sama dengan :value.',
    ],
    'mac_address'          => ':attribute harus berupa alamat MAC yang valid.',
    'max'                  => [
        'numeric' => ':attribute tidak boleh lebih besar dari :max.',
        'file'    => ':attribute tidak boleh lebih besar dari :max kilobyte.',
        'string'  => ':attribute tidak boleh lebih panjang dari :max karakter.',
        'array'   => ':attribute tidak boleh memiliki lebih dari :max item.',
    ],
    'mimes'                => ':attribute harus berupa berkas dengan tipe: :values.',
    'mimetypes'            => ':attribute harus berupa berkas dengan tipe: :values.',
    'min'                  => [
        'numeric' => ':attribute harus memiliki setidaknya :min.',
        'file'    => ':attribute harus berukuran setidaknya :min kilobyte.',
        'string'  => ':attribute harus memiliki setidaknya :min karakter.',
        'array'   => ':attribute harus memiliki setidaknya :min item.',
    ],
    'multiple_of'          => ':attribute harus merupakan kelipatan dari :value.',
    'not_in'               => ':attribute dipilih yang tidak valid.',
    'not_regex'            => ':attribute tidak sesuai dengan pola yang valid.',
    'numeric'              => ':attribute harus berupa angka.',
    'password'             => 'Kata sandi tidak sesuai dengan kriteria yang diterapkan.',
    'present'              => ':attribute harus ada.',
    'prohibited'           => ':attribute dilarang.',
    'prohibited_if'        => ':attribute dilarang ketika :other adalah :value.',
    'prohibited_unless'    => ':attribute dilarang kecuali :other ada di :values.',
    'prohibits'            => ':attribute melarang :other dari ada.',
    'regex'                => ':attribute tidak sesuai dengan pola yang valid.',
    'relatable_attribute'  => 'Kolom relasi untuk :attribute tidak tersedia.',
    'required'             => ':attribute wajib diisi.',
    'required_array_keys'  => ':attribute harus memiliki kunci: :values.',
    'required_if'          => ':attribute wajib diisi ketika :other adalah :value.',
    'required_unless'      => ':attribute wajib diisi kecuali :other ada di :values.',
    'required_with'        => ':attribute wajib diisi ketika :values ada.',
    'required_with_all'    => ':attribute wajib diisi ketika :values ada.',
    'required_without'     => ':attribute wajib diisi ketika :values tidak ada.',
    'required_without_all' => ':attribute wajib diisi ketika :values tidak ada.',
    'same'                 => ':attribute dan :other harus cocok.',
    'size'                 => [
        'numeric' => ':attribute harus bernilai :size.',
        'file'    => ':attribute harus berukuran :size kilobyte.',
        'string'  => ':attribute harus berisi :size karakter.',
        'array'   => ':attribute harus mengandung :size item.',
    ],
    'starts_with'          => ':attribute harus diawali dengan salah satu dari: :values.',
    'string'               => ':attribute harus berupa teks.',
    'timezone'             => ':attribute harus berupa zona waktu yang valid.',
    'unique'               => ':attribute sudah digunakan.',
    'uploaded'             => ':attribute gagal diunggah. Silakan coba lagi atau pilih berkas yang lebih kecil.',
    'url'                  => ':attribute format URL tidak valid.',
    'uuid'                 => ':attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | attribute convention. This is useful for giving specific messages for
    | specific attributes without having to check each rule manually.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute placeholders
    | with something more reader friendly such as "E-Mail Address" instead
    | of simply "email".
    |
    */

    'attributes' => [],

];