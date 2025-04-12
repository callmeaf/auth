<?php

namespace Callmeaf\Auth\App\Http\Resources\Admin\V1;

use Callmeaf\Auth\App\Models\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Auth $resource
 */
class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            $this->mergeWhen(isPostmanRequest() && ! ! $this->token, [
                'token' => $this->token,
            ])
        ];
    }
}
