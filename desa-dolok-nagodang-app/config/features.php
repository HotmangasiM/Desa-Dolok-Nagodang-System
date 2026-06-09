<?php

return [
    'public_letter_submission' => env('FEATURE_PUBLIC_SUBMISSION', false),
    'registration' => env('FEATURE_REGISTRATION', in_array(env('APP_ENV', 'production'), ['local', 'testing'], true)),
];
