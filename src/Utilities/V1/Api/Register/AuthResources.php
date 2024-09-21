<?php

namespace Callmeaf\Auth\Utilities\V1\Api\Register;

use Callmeaf\Base\Utilities\V1\Resources;

class AuthResources extends Resources
{
    public function userShow(): self
    {
        $this->data = [
            'relations' => [
                'carts',
            ],
            'attributes' => [
                'id',
                'status',
                'status_text',
                'type',
                'type_text',
                'first_name',
                'last_name',
                'full_name',
                'mobile',
                'email',
                'email_verified_at',
                'national_code',
                'carts',
                '!carts' => [
                    'id',
                    'type',
                    'type_text',
                    'items',
                    '!items' => [
                        'variation_id',
                        'qty',
                    ],
                ],
            ],
        ];
        return $this;
    }

    public function userUpdate(): self
    {
        $this->data = [
            'relations' => [],
            'attributes' => [
                'id',
                'status',
                'status_text',
                'type',
                'type_text',
                'first_name',
                'last_name',
                'full_name',
                'mobile',
                'email',
                'email_verified_at',
                'national_code',
            ],
        ];
        return $this;
    }

    public function verifyEmail(): self
    {
        $this->data = [
            'relations' => [],
            'attributes' => [
                'id',
                'status',
                'status_text',
                'type',
                'type_text',
                'first_name',
                'last_name',
                'full_name',
                'mobile',
                'email',
                'email_verified_at',
                'national_code',
            ],
        ];
        return $this;
    }

    public function profileImageUpdate(): self
    {
        $this->data = [
            'relations' => [],
            'attributes' => [
                'id',
                'status',
                'status_text',
                'type',
                'type_text',
                'first_name',
                'last_name',
                'full_name',
                'mobile',
                'email',
                'email_verified_at',
                'national_code',
                'image',
                '!image' => [
                    'id',
                    'url'
                ],
            ],
        ];
        return $this;
    }
}
