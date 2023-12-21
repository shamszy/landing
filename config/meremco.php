<?php

return [

    'paystack' => [
        'key' => env('PAYSTACK_SECRET_KEY'),
        'url' => env('PAYSTACK_URL', 'https://api.paystack.co')
    ],

];

