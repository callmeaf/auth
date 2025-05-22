<?php

namespace Callmeaf\Auth\App\Repo\Contracts;

use App\Models\User;
use Callmeaf\Auth\App\Models\Auth;
use Callmeaf\Base\App\Repo\Contracts\CoreRepoInterface;
use Callmeaf\Auth\App\Http\Resources\Api\V1\AuthResource as ApiAuthResource;
use Callmeaf\Auth\App\Http\Resources\Admin\V1\AuthResource as AdminAuthResource;
use Callmeaf\Auth\App\Http\Resources\Web\V1\AuthResource as WebAuthResource;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @extends CoreRepoInterface<Auth,ApiAuthResource|WebAuthResource|AdminAuthResource,null>
 */
interface AuthRepoInterface extends CoreRepoInterface
{
    /**
     * @return ApiAuthResource|WebAuthResource|AdminAuthResource
     */
    public function login(string $identifier, string $code, bool $remember = false);
    /**
     * @return ApiAuthResource|WebAuthResource|AdminAuthResource
     */
    public function loginViaPassword(string $identifier, string $password, bool $remember = false);

    public function newToken(): string;

    /**
     * @return ApiAuthResource|WebAuthResource|AdminAuthResource
     */
    public function user();

    public function logout(): int;

    /**
     * @param User $user
     * @return bool
     * @throws \Callmeaf\Auth\App\Exceptions\UserAccountIsInActiveException
     * @throws \Callmeaf\Auth\App\Exceptions\UserAccountIsPendingException
     * @throws \Callmeaf\Auth\App\Exceptions\UserAccountSoftDeletedException
     */
    public function checkUserStatus($user): bool;

    /**
     * @param array $data
     * @return ApiAuthResource|WebAuthResource|AdminAuthResource
     */
    public function updateProfile(array $data,?UploadedFile $image = null);

    /**
     * @param string $password
     * @param string $code
     * @return ApiAuthResource|WebAuthResource|AdminAuthResource
     */
    public function updatePassword(string $password,string $code);

    /**
     * @param bool $value
     * @return ApiAuthResource|WebAuthResource|AdminAuthResource
     */
    public function acceptTerms(bool $value);
}
