<?php

namespace App\Support;

class Asset
{
    /**
     * Build a URL for an INSPIN-hosted storage asset (article images, audio,
     * team logos, expert avatars). Sportshandicapper shares its picks and
     * articles with INSPIN, but the actual uploaded files live on INSPIN's
     * server, so these need to point there instead of this app's own storage.
     */
    public static function inspin(string $path): string
    {
        $base = rtrim(config('inspin.asset_url'), '/');

        return $base.'/storage/'.$path;
    }
}
