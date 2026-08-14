<?php

declare(strict_types=1);

namespace Rimba\Idp\Policies;

use Illuminate\Contracts\Auth\Authenticatable;
use Rimba\Idp\Models\IdpClient;

class IdpClientPolicy
{
    public function viewAny(Authenticatable $user): bool
    {
        return $this->allowed($user, 'idp.clients.view');
    }

    public function view(Authenticatable $user, IdpClient $client): bool
    {
        return $this->allowed($user, 'idp.clients.view');
    }

    public function create(Authenticatable $user): bool
    {
        return $this->allowed($user, 'idp.clients.create');
    }

    public function update(Authenticatable $user, IdpClient $client): bool
    {
        return $this->allowed($user, 'idp.clients.update');
    }

    public function delete(Authenticatable $user, IdpClient $client): bool
    {
        return false;
    }

    private function allowed(Authenticatable $user, string $permission): bool
    {
        $staff = data_get($user, config('idp.claim_paths.staff_relation', 'staff'));

        return $staff && method_exists($staff, 'can') && $staff->can($permission);
    }
}
