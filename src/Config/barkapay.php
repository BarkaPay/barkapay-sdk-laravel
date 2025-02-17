<?php

return [
    'api_key' => env('BKP_API_KEY', ''),
    'api_secret' => env('BKP_API_SECRET', ''),
    'sci_key' => env('BKP_SCI_KEY', ''),
    'sci_secret' => env('BKP_SCI_SECRET', ''),

    // Base URL of the BarkaPay API to access client resources
    'base_url' => env('BKP_BASE_URL', 'https://api.barkapay.com/api/client/'),

    // Default currency for transactions (e.g., XOF for West African CFA franc)
    'currency' => 'xof',
];
