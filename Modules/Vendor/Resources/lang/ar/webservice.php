<?php

return [
    'rates'   => [
        'user_rate_before'          => 'تم التقييم من قبل',
        'user_not_have_order'       => 'هذا الطلب غير تابع للمستخدم',
        'rated_successfully'        => 'تم تقييم الصيدلية بنجاح',
        'btnClose'                  => 'خروج',
        'your_rate'                 => 'تقييمك',
        'rate_now'                  => 'قيم الآن',
        'ratings'                   => 'تقييمات',
        'validation'  => [
            'order_id'    => [
                'required' => 'رقم الطلب مطلوب',
                'exists' => 'رقم الطلب غير موجود فى جدول الطلبات',
            ],
            'rating'    => [
                'required' => 'التقييم مطلوب',
                'integer' => 'قيمة التقييم لابد ان تكون رقمية',
                'between' => 'قيمة التقييم لابد ان تكون بين 1 و 5',
            ],
            'comment'    => [
                'string' => 'التعليق لابد ان يكون قيمة نصية',
                'max' => 'التعليق يجب ألا يتجاوز 1000 حرف',
            ],
        ],
    ],
    'companies' =>  [
        'vendor_not_found_with_this_state' =>  'المنطقة غير موجوده مع المتجر',
    ],
    'vendors' =>  [
        'vendor_not_found' => 'هذا المتجر غير متاح حاليا',
        'vendor_statuses' => [
            'open' => 'مفتوح',
            'closed' => 'مغلق',
            'busy' => 'مشغول',
        ],
    ],
    'vendor_requests'        => [
        'form' => [
            'name' => 'الإسم',
            'vendor_name' => 'اسم المتجر',
            'vendor_short_decription'   => 'الوصف المختصر للمتجر',
            'mobile' => 'رقم الهاتف',
            'vendor_email' => 'البريد الإلكترونى',
            'image' => 'الشعار',
            'btn' => [
                'register' => 'تسجيل',
            ],
        ],
        'alerts' => [
            'created_successfully' => 'تم إرسال طلبكم بنجاح',
            'error_occured' => 'حدث خطأ ما, يرجى المحاولة لاحقا',
        ],
        'validation'    =>  [
            'image' => [
                'required' => 'من فضلك ادخل الصورة',
                'image' => 'من فضلك ادخل الصورة من نوع صورة',
                'mimes' => 'الصورة يجب ان تكون ضمن',
                'max' => 'حجم الصورة يجب الا يزيد عن',
            ],
        ],
    ],
];
