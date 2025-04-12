<?php

namespace Callmeaf\Auth\App\Strategy\Contracts;

/**
 * @template TModel
 */
interface AuthStrategyInterface
{
    public function sendOtp(string $identifier): string;

    public function verifyOtp(string $identifier, string $code): bool;

    /**
     * @param string $identifier
     * @return TModel
     */
    public function createUser(string $identifier);

    /**
     * @param string $identifier
     * @param bool $remember
     * @return TModel
     */
    public function attempt(string $identifier, bool $remember = false);
}
