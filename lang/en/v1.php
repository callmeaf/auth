<?php

return [
    'mails' => [
        'welcome' => [
            'title' => 'Welcome!',
            'content' => 'Welcome to biggest group :title in the world.',
            'footer' => 'Thanks,',
            'link' => 'Login to your account',
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
    ],
];
