<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;

    public function view(): bool
    {
        return auth()->check();
    }

    public function create(): bool
    {
        return auth()->check();
    }

    public function update(): bool
    {
        return auth()->check();
    }

    public function delete(): bool
    {
        return auth()->check();
    }
}
