<?php

return [
    'rates'   => [
        'user_rate_before'          => 'Already rated',
        'user_not_have_order'       => 'This request is not affiliated with the user',
        'rated_successfully'        => 'The pharmacy has been successfully rated',
        'btnClose'                  => 'Close',
        'your_rate'                 => 'Your Rate',
        'rate_now'                  => 'Rate Now',
        'ratings'                   => 'Ratings',
        'validation'  => [
            'order_id'    => [
                'required' => 'Order id is required',
                'exists' => 'Order id is not existed in orders table',
            ],
            'rating'    => [
                'required' => 'Rating is required',
                'integer' => 'Rating must be integer',
                'between' => 'Rating value must be between 1 and 5',
            ],
            'comment'    => [
                'string' => 'Comment must be string',
                'max' => 'Comment must not exceed 1000 characters',
            ],
        ],
    ],
    'companies' =>  [
        'vendor_not_found_with_this_state'      =>  'This state is not found with this vendor',
    ],
    'vendors' =>  [
        'vendor_not_found' => 'This vendor is not found',
        'vendor_statuses' => [
            'open' => 'Open',
            'closed' => 'Closed',
            'busy' => 'Busy',
        ],
    ],
    'vendor_requests'        => [
        'form' => [
            'name' => 'Name',
            'vendor_name' => 'Vendor Name',
            'vendor_short_decription'   => 'Vendor Short Decription',
            'mobile' => 'Mobile',
            'vendor_email' => 'Email',
            'image' => 'Logo',
            'btn' => [
                'register' => 'Register',
            ],
        ],
        'alerts' => [
            'created_successfully' => 'Your request has been successfully sent',
            'error_occured' => 'Something went wrong, please try again later',
        ],
        'validation'    =>  [
            'image' => [
                'required' => 'Pleas select image',
                'image' => 'Image file should be an image',
                'mimes' => 'Image must be in',
                'max' => 'The image size should not be more than',
            ],
        ],
    ],
];
