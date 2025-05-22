<?php

namespace Callmeaf\Auth\App\Http\Resources\Api\V1;

use Callmeaf\Auth\App\Models\Auth;
use Callmeaf\Media\App\Repo\Contracts\MediaRepoInterface;
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
        /**
         * @var MediaRepoInterface $mediaRepo
         */
        $mediaRepo = app(MediaRepoInterface::class);
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'accepted_terms' => $this->accepted_terms,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'image' => $mediaRepo->toResource($this->whenLoaded('image')),
            $this->mergeWhen(! empty($this->token), [
                'token' => $this->token,
            ])
        ];
    }
}
