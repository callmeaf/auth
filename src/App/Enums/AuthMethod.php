<?php

namespace Callmeaf\Auth\App\Enums;

enum AuthMethod: string
{
    case VIA_MOBILE = 'via_mobile';
    case VIA_EMAIL_AND_VERIFICATION = 'via_email_and_verification';
}
