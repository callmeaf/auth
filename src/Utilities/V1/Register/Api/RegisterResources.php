<?php

namespace Callmeaf\Auth\Utilities\V1\Register\Api;

use Callmeaf\Base\Utilities\V1\Resources;

class RegisterResources extends Resources
{
    public function register(): self
    {
        $this->data = [
            'relations' => [],
            'attributes' => [
                'id',
                'first_name',
                'last_name',
                'mobile',
                'email',
                'email_verified_at',
                'national_code',
            ],
        ];
        return $this;
    }

    public function registerViaMobile(): self
    {
        $this->data = [
            'relations' => [

            ],
            'attributes' => [
                'id',
                'mobile',
            ],
        ];
        return $this;
    }

    public function registerViaEmail(): self
    {
        $this->data = [
            'relations' => [],
            'attributes' => [
                'id',
                'email',
                'email_verified_at',
            ],
        ];
        return $this;
    }
}
