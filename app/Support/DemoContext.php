<?php

namespace App\Support;

use App\Models\User;

class DemoContext
{
    public function __construct(public ?User $user = null)
    {
    }

    public function isDemo(): bool
    {
        return $this->user !== null && (bool) $this->user->is_demo;
    }
}
