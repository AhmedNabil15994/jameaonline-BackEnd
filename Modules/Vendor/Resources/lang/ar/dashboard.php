<?php

return [
    'payments' => [
        'create' => [
            'form' => [
                'code' => 'كود الدفع',
                'general' => 'بيانات عامة',
                'image' => 'الصورة',
                'info' => 'البيانات',
            ],
            'title' => 'اضافة طرق الدفع',
        ],
        'datatable' => [
            'code' => 'كود الدفع',
            'created_at' => 'تاريخ الإنشاء',
            'date_range' => 'البحث بالتواريخ',
            'image' => 'الصورة',
            'options' => 'الخيارات',
        ],
        'index' => [
            'title' => 'طرق الدفع',
        ],
        'update' => [
            'form' => [
                'code' => 'كود الدفع',
                'general' => 'بيانات عامة',
                'image' => 'الصورة',
            ],
            'title' => 'تعديل طريقة الدفع',
        ],
        'validation' => [
            'code' => [
                'required' => 'من فضلك ادخل كود الدفع',
                'unique' => 'هذا الكود تم ادخالة من قبل',
            ],
            'image' => [
                'required' => 'من فضلك اختر الصورة',
            ],
        ],
    ],
    'sections' => [
        'create' => [
            'form' => [
                'description' => 'الوصف',
                'general' => 'بيانات عامة',
                'info' => 'البيانات',
                'meta_description' => 'Meta Description',
                'meta_keywords' => 'Meta Keywords',
                'seo' => 'SEO',
                'status' => 'الحالة',
                'title' => 'العنوان',
                'image' => 'الصورة',
            ],
            'title' => 'اضافة انواع المتاجر',
        ],
        'datatable' => [
            'created_at' => 'تاريخ الإنشاء',
            'date_range' => 'البحث بالتواريخ',
            'options' => 'الخيارات',
            'status' => 'الحالة',
            'title' => 'العنوان',
        ],
        'index' => [
            'title' => 'انواع المتاجر',
        ],
        'update' => [
            'form' => [
                'description' => 'الوصف',
                'general' => 'بيانات عامة',
                'meta_description' => 'Meta Description',
                'meta_keywords' => 'Meta Keywords',
                'seo' => 'SEO',
                'status' => 'الحالة',
                'title' => 'العنوان',
                'image' => 'الصورة',
            ],
            'title' => 'تعديل انواع المتاجر',
        ],
        'validation' => [
            'description' => [
                'required' => 'من فضلك ادخل الوصف',
            ],
            'title' => [
                'required' => 'من فضلك ادخل العنوان',
                'unique' => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
    'vendor_statuses' => [
        'create' => [
            'form' => [
                'accepted_orders' => 'حالة استقبال الطلبات',
                'info' => 'البيانات',
                'label_color' => 'لون العلامة',
                'title' => 'العنوان',
            ],
            'title' => 'اضافة حالات المتجر',
        ],
        'datatable' => [
            'accepted_orders' => 'حالة استقبال الطلبات',
            'created_at' => 'تاريخ الإنشاء',
            'date_range' => 'البحث بالتواريخ',
            'label_color' => 'لون العلامة',
            'options' => 'الخيارات',
            'title' => 'العنوان',
        ],
        'index' => [
            'title' => 'حالات المتجر',
        ],
        'update' => [
            'form' => [
                'accepted_orders' => 'حالة استقبال الطلبات',
                'general' => 'بيانات عامة',
                'label_color' => 'لون العلامة',
                'title' => 'العنوان',
            ],
            'title' => 'تعديل حالات المتجر',
        ],
        'validation' => [
            'accepted_orders' => [
                'unique' => 'لا يمكن اكثر من حالة لستقبال الطلبات',
            ],
            'label_color' => [
                'required' => 'من فضلك اختر لون العلامة',
            ],
        ],
    ],
    'vendors' => [
        'create' => [
            'form' => [
                'commission' => 'نسبة الربح من المتجر',
                'description' => 'الوصف',
                'fixed_commission' => 'نسبة ربح ثابتة',
                'fixed_delivery' => 'سعر التوصيل الثابت',
                'general' => 'بيانات عامة',
                'image' => 'الصورة',
                'logo' => 'اللوجو',
                'info' => 'البيانات',
                'is_trusted' => 'صلاحيات الاضافة',
                'meta_description' => 'Meta Description',
                'meta_keywords' => 'Meta Keywords',
                'order_limit' => 'الحد الادنى للطلب',
                'other' => 'بيانات اخرى',
                'payments' => 'طرق الدفع المدعومة',
                'products' => 'تصدير المنتجات',
                'receive_prescription' => 'استقبال الوصفات الطبية',
                'receive_question' => 'استقبال الأسئلة',
                'sections' => 'نوع المتجر',
                'sellers' => 'بائعين المتجر',
                'seo' => 'SEO',
                'status' => 'الحالة',
                'busy' => 'مشغول',
                'title' => 'عنوان',
                'vendor_email' => 'البريد الالكتروني للمتجر',
                'vendor_statuses' => 'حالة المتجر',
                'companies' => 'شركات التوصيل',
                'companies_and_states' => 'التوصيل',
                'states' => 'يرجى تحديد المناطق التي يتم التوصيل إليها',
                'categories' => 'الأقسام',
                'working_hours' => 'ساعات العمل',
                'offer_text' => 'الخصم',
                'delivery_time_types' => [
                    'title' => 'آلية وقت التوصيل',
                    'direct' => 'الطلب مباشرة',
                    'schedule' => 'تحديد وقت الطلب',
                    'direct_delivery_message' => 'رسالة وقت الطلب المباشر',
                ],
                'payment' => 'بيانات بوابة الدفع',
                'mobile' => 'رقم الهاتف',
                'whatsapp' => 'رقم الواتس اب',
                'address' => 'العنوان / المكان',
            ],
            'title' => 'اضافة المتاجر',
        ],
        'datatable' => [
            'created_at' => 'تاريخ الإنشاء',
            'date_range' => 'البحث بالتواريخ',
            'image' => 'الصورة',
            'options' => 'الخيارات',
            'status' => 'الحالة',
            'title' => 'العنوان',
            'products' => 'المنتجات',
            'no_products_data' => 'لا يوجد منتجات حالياً',
            'total' => 'الإجمالى',
            'per_page' => 'اجمالى الصفحة',
            'section' => 'النوع',
        ],
        'index' => [
            'sorting' => 'ترتيب المتاجر',
            'title' => 'المتاجر',
        ],
        'sorting' => [
            'title' => 'ترتيب المتاجر',
        ],
        'update' => [
            'form' => [
                'commission' => 'نسبة الربح من المتجر',
                'description' => 'الوصف',
                'general' => 'بيانات عامة',
                'image' => 'الصورة',
                'logo' => 'اللوجو',
                'info' => 'البيانات',
                'is_trusted' => 'صلاحيات الاضافة',
                'meta_description' => 'Meta Description',
                'meta_keywords' => 'Meta Keywords',
                'order_limit' => 'الحد الادنى للطلب',
                'other' => 'بيانات اخرى',
                'payments' => 'طرق الدفع المدعومة',
                'products' => 'تصدير المنتجات',
                'receive_prescription' => 'استقبال الوصفات الطبية',
                'receive_question' => 'استقبال الاسالة',
                'sections' => 'نوع المتجر',
                'sellers' => 'بائعين المتجر',
                'seo' => 'SEO',
                'status' => 'الحالة',
                'busy' => 'مشغول',
                'title' => 'عنوان',
                'vendor_email' => 'البريد الالكتروني للمتجر',
                'categories' => 'الأقسام',
                'working_hours' => 'ساعات العمل',
                'offer_text' => 'الخصم',
                'delivery_time_types' => [
                    'title' => 'آلية وقت التوصيل',
                    'direct' => 'الطلب مباشرة',
                    'schedule' => 'تحديد وقت الطلب',
                ],
                'payment' => 'بيانات بوابة الدفع',
                'mobile' => 'رقم الهاتف',
                'whatsapp' => 'رقم الواتس اب',
                'address' => 'العنوان / المكان',
            ],
            'title' => 'تعديل المتجر',
        ],
        'validation' => [
            'commission' => [
                'numeric' => 'من فضلك ادخل نسبه الربح ارقام انجليزية فقط',
                'required' => 'من فضلك ادخل نسبه الربح',
            ],
            'fixed_commission' => [
                'numeric' => 'من فضلك ادخل نسبة الربح الثابتة ارقام انجليزية فقط',
                'required' => 'من فضلك ادخل نسبة ربح ثابتة',
            ],
            'description' => [
                'required' => 'من فضلك ادخل الوصف',
            ],
            'fixed_delivery' => [
                'numeric' => 'من فضلك ادخل سعر التوصيل الثابت ارقام انجليزية فقط',
                'required' => 'من فضلك ادخل سعر التوصيل الثابت',
            ],
            'image' => [
                'required' => 'من فضلك ادخل الصورة',
                'image' => 'من فضلك ادخل الصورة من نوع صورة',
                'mimes' => 'الصورة يجب ان تكون ضمن',
                'max' => 'حجم الصورة يجب الا يزيد عن',
            ],
            'logo' => [
                'required' => 'من فضلك ادخل اللوجو',
                'image' => 'من فضلك ادخل اللوجو من نوع صورة',
                'mimes' => 'اللوجو يجب ان تكون ضمن',
                'max' => 'حجم اللوجو يجب الا يزيد عن',
            ],
            'months' => [
                'numeric' => 'من فضلك ادخل عدد شهور الباقة ارقام فقط',
                'required' => 'من فضلك ادخل عدد شهور الباقة',
            ],
            'order_limit' => [
                'numeric' => 'من فضلك ادخل الاحد الادنى كا ارقام انجليزية فقط : 5.000',
                'required' => 'من فضلك ادخل الحد الادنى للمتجر : 5.000',
            ],
            'payments' => [
                'required' => 'من فضلك اختر طرق الدفع المدعومة من قبل هذا المتجر',
            ],
            'price' => [
                'numeric' => 'من فضلك ادخل سعر الباقة ارقام فقط',
                'required' => 'من فضلك ادخل سعر الباقة',
            ],
            'sections' => [
                'required' => 'من فضلك اختر نوع المتجر',
                'exists' => 'نوع المتجر غير موجود حاليا',
            ],
            'sellers' => [
                'required' => 'من فضلك اختر البائعين لهذا المتجر',
            ],
            'special_price' => [
                'numeric' => 'من فضلك ادخل السعر الخاص ارقام فقط',
            ],
            'title' => [
                'required' => 'من فضلك ادخل العنوان',
                'unique' => 'هذا العنوان تم ادخالة من قبل',
            ],
            'products' => [
                'ids' => [
                    'required' => 'من فضلك اختر مصفوفة من الاختيارات او على الاقل اختيار واحد',
                ],
            ],
            'vendor_category_id' => [
                'required' => 'من فضلك اختر على الاقل قسم واحد',
                'exists' => 'قسم المتجر غير موجود حاليا',
            ],
            'mobile' => [
                'digits_between' => 'من فضلك ادخل ٨ ارقام فقط داخل رقم الهاتف',
                'numeric' => 'يجب ان يتكون رقم الهاتف من ارقام فقط بالانجليزية',
                'required' => 'من فضلك ادخل رقم الهاتف',
                'unique' => 'رقم الهاتف تم ادخالة من قبل',
            ],
            'payment_methods' => [
                'required' => 'من فضلك اختر طريقة الدفع',
                'in' => 'طريقة الدفع يجب ان تكون ضمن',
            ],
        ],
        'products' => [
            'title' => 'منتجات المتجر',
            'table' => [
                'title' => 'عنوان المنتج',
                'quantity' => 'الكمية',
                'price' => 'السعر',
                'status' => 'الحالة',
            ],
        ],
        'availabilities'    =>  [
            'times' =>  'توقيتات التوصيل',
            'days'  =>  [
                'sat'   =>  'السبت',
                'sun'   =>  'الأحد',
                'mon'   =>  'الإثنين',
                'tue'   =>  'الثلاثاء',
                'wed'   =>  'الأربعاء',
                'thu'   =>  'الخميس',
                'fri'   =>  'الجمعة',
            ],
            'form'  =>  [
                'time_from' =>  'الوقت من',
                'time_to' =>  'الوقت الى',
                'time' =>  'الوقت',
                'day' =>  'اليوم',
                'for_day' =>  'ليوم',
                'time_status' =>  'حالة الوقت',
                'full_time' =>  'عمل 24 ساعة',
                'custom_time' =>  'تحديد الوقت',
                'btn_add_more' =>  'اضافة المزيد',
                'at_least_one_element' =>  'مطلوب عنصر واحد على الأقل !!',
                'greater_than' =>  'اكبر من',
                'contain_duplicated_values' =>  'يحتوى على توقيتات مكررة',
            ],
        ],
        'tabs' => [
            "availabilities"    => "مواعيد العمل",
            "delivery_times"    => "مواعيد التوصيل",
            "show_delivery_times"    => "عرض مواعيد التوصيل",
        ],
        'payment' => [
            'charges' => 'قيمة charges',
            'cc_charges' => 'قيمة cc charges',
            'ibans' => 'iban',
        ],
    ],
    'categories' => [
        'datatable' => [
            'created_at' => 'تاريخ الإنشاء',
            'date_range' => 'البحث بالتواريخ',
            'image' => 'الصورة',
            'options' => 'الخيارات',
            'status' => 'الحالة',
            'title' => 'العنوان',
            'type' => 'النوع',
        ],
        'form' => [
            'image' => 'الصورة',
            'cover' => 'صورة الغلاف',
            'main_category' => 'قسم رئيسي',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'status' => 'الحالة',
            'show_in_home' => 'يظهر فى الرئيسية',
            'tabs' => [
                'category_level' => 'مستوى الاقسام',
                'general' => 'بيانات عامة',
                'seo' => 'SEO',
                "input_lang" => "بيانات :lang",
            ],
            'title' => 'عنوان',
            'color' => 'اللون',
            'sort' => 'الترتيب',
            'color_hint' => 'اللون بطريقة Hex Color - على سبيل المثال: FFFFFF',
        ],
        'routes' => [
            'create' => 'اضافة اقسام المتاجر',
            'index' => 'اقسام المتاجر',
            'update' => 'تعديل اقسام المتاجر',
        ],
        'validation' => [
            'vendor_category_id' => [
                'required' => 'من فضلك اختر مستوى القسم',
            ],
            'image' => [
                'required' => 'من فضلك اختر الصورة',
            ],
            'title' => [
                'required' => 'من فضلك ادخل العنوان',
                'unique' => 'هذا العنوان تم ادخالة من قبل',
            ],
            'color' => [
                'required_if' => 'من فضلك ادخل لون للقسم الرئيسى',
            ],
        ],
    ],
    'delivery_charges' => [
        'create' => [
            'form' => [
                'delivery' => 'قيمة التوصيل',
                'general' => 'بيانات عامة',
                'info' => 'البيانات',
                'state' => 'Meta Description',
                'vendor' => 'المطعم',
            ],
            'title' => 'اضافة قيم التوصيل',
        ],
        'datatable' => [
            'created_at' => 'تاريخ الإنشاء',
            'date_range' => 'البحث بالتواريخ',
            'delivery' => 'قيم التوصيل',
            'options' => 'الخيارات',
            'state' => 'عدد مناطق التوصيل',
            'company' => 'شركة الشحن',
            'vendor' => 'الفرع',
        ],
        'index' => [
            'title' => 'قيم التوصيل',
        ],
        'update' => [
            'charge' => 'قيمة التوصيل / دينار كويتي',
            'form' => [
                'delivery' => 'قيمة التوصيل',
                'general' => 'بيانات عامة',
                'state' => 'المنطقة',
                'vendor' => 'المطعم',
            ],
            'time' => 'وقت التوصيل / دقائق',
            'min_order_amount' => 'الحد الادنى للطلب',
            'title' => 'تعديل قيم التوصيل',
            'state' => 'المنطقة',
            'delivery_time' => 'وقت التوصيل',
            'delivery_price' => 'سعر التوصيل',
            'status' => 'الحالة',
            'btn' => [
                'copy' => 'نسخ',
                'activate_all' => 'تفعيل الكل',
            ],
        ],
        'validation' => [
            'delivery' => [
                'numeric' => 'من فضلك ادخل قيمة التوصيل ارقام فقط',
                'required' => 'من فضلك ادخل قيمة التوصيل',
                'array' => 'قيمة التوصيل لابد ان تكون مصفوفة',
            ],
            'state' => [
                'numeric' => 'من فضلك اختر المنطقة ارقام فقط',
                'required' => 'من فضلك اختر المنطقة',
                'array' => 'منطقة التوصيل لابد ان تكون مصفوفة',
            ],
            'vendor' => [
                'numeric' => 'من فضلك اختر المطعم ارقام فقط',
                'required' => 'من فضلك اختر المطعم',
            ],
            'company' => [
                'numeric' => 'من فضلك اختر الشركة ارقام فقط',
                'required' => 'من فضلك اختر الشركة',
            ],
        ],
    ],
    'vendor_requests' => [
        'datatable' => [
            'name' => 'اسم العميل',
            'vendor_name' => 'اسم المتجر',
            'mobile' => 'رقم الهاتف',
            'created_at' => 'تاريخ الإنشاء',
            'date_range' => 'البحث بالتواريخ',
            'image' => 'الصورة',
            'section' => 'النوع',
            'options' => 'الخيارات',
        ],
        'index' => [
            'title' => 'طلبات التسجيل',
        ],
        'show' => [
            'form' => [
                'name' => 'اسم العميل',
                'vendor_name' => 'اسم المتجر',
                'mobile' => 'رقم الهاتف',
                'general' => 'بيانات عامة',
                'image' => 'الصورة',
            ],
            'title' => 'عرض طلب التسجيل',
        ],
    ],
];
