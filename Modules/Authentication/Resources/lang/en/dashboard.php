<?php

return [
    'login' => [
        'form'          => [
            'btn'       => [
                'login' => 'Login Now',
                'deactivate' => 'Deactivate Now',
            ],
            'email'     => 'ِEmail address',
            'password'  => 'Password',
        ],
        'routes'        => [
            'index' => 'Login',
            'deactivate'    => 'Deactivate Account',
        ],
        'validations'   => [
            'email'     => [
                'email'     => 'Please add correct email format',
                'required'  => 'Please add your email address',
            ],
            'failed'    => 'These credentials do not match our records.',
            'password'  => [
                'min'       => 'Password must be more than 6 characters',
                'required'  => 'The password field is required',
            ],
        ],
    ],
];
