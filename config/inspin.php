<?php

return [

    // Base URL for INSPIN-hosted storage assets (article images, audio,
    // pick team logos) shared with this app's 'inspin' database connection.
    'asset_url' => env('INSPIN_ASSET_URL', env('APP_URL', 'http://localhost')),

];
