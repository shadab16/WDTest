<?php

namespace App\Entity;

class PermissionsBag
{
    private $permissions;
    private $lookup;

    public function __construct(array $permissions)
    {
        $this->permissions = [];
        $this->lookup = [];
        foreach ($permissions as $permission)
        {
            $this->permissions[] = (string) $permission;
            $this->lookup[(string) $permission] = true;
        }
    }

    public function has(string $permission): boolean
    {
        return ($this->lookup[$permission] === true);
    }

    public function getAll()
    {
        return $this->permissions;
    }
}
