<?php

return [
    'mails' => [
        'welcome' => [
            'subject' => 'Welcome Mail',
            'title' => 'Welcome!',
            'content' => 'Welcome to biggest group :title in the world.',
            'footer' => 'Thanks,',
            'link' => 'Login to your account',
        ],
        'forgot_password' => [
            'subject' => 'Forgot Password Mail',
            'title' => 'Forgot Password Code',
            'content' => 'Your verify forgot password',
        ],
    ],
    'errors' => [
        'user_account_not_found' => 'User account not found.',
        'unauthorized' => 'Unauthorized.',
        'authenticated' => 'Already Authenticated.',
        'current_password_incorrect' => 'Current password incorrect.',
        'user_has_already_password' => 'The desired user account has a password, use the `update password` method to change the password.',
        'access_denied' => 'You do not have the necessary permission to do so.',
        'not_found' => 'Page not found.',
        'wait_for_new_password_reset_token' => 'Try later for resend new forgot password code.',
        'password_reset_code_wrong' => 'Password reset code was wrong.',
        'password_reset_code_expired' => 'Password reset code expired. ( try again forgot password process to get new code. )',
    ],
];
