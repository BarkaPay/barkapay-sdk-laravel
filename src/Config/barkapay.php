<?php

return [
    'api_key' => env('BKP_API_KEY', ''),
    'api_secret' => env('BKP_API_SECRET', ''),
    'sci_key' => env('BKP_SCI_KEY', ''),
    'sci_secret' => env('BKP_SCI_SECRET', ''),
    'base_url' => env('BKP_BASE_URL', 'https://api.barkapay.com/api/client/'),
    'currency' => 'xof',
];
