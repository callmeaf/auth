<?php

namespace Callmeaf\Auth\Events;

use Callmeaf\User\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VerifiedEmail
{
    use SerializesModels,Dispatchable;


    /**
     * Create a new event instance.
     *
     */
    public function __construct(public User $user)
    {

    }
}
