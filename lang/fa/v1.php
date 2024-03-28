<?php

return [
    'mails' => [
        'welcome' => [
            'title' => 'خوش آمدید!',
            'content' => 'به گروه بزرگ :title خوش آمدید.',
            'footer' => 'ممنون،',
            'link' => 'ورود به حساب کاربری',
        ],
    ],
    'errors' => [
        'user_account_not_found' => 'حساب کاربری یافت نشد.',
        'unauthorized' => 'احراز هویت نشده.',
        'authenticated' => 'قبلا احراز هویت شده.',
        'current_password_incorrect' => 'رمزعبور فعلی اشتباه میباشد.',
        'user_has_already_password' => 'حساب کاربر مورد نظر دارای رمز عبور میباشد، برای تغییر رمزعبور از متد به `روزرسانی رمزعبور` استفاده کنید.',
    ],
];
