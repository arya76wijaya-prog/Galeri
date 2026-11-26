<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VisitorIdentity
{
    public static function get(Request $request): string
    {
        $visitorId = $request->session()->get('visitor_id');

        if (! $visitorId) {
            $visitorId = (string) Str::uuid();
            $request->session()->put('visitor_id', $visitorId);
        }

        return $visitorId;
    }
}
