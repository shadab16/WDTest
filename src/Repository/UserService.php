<?php

namespace App\Repository;
use Doctrine\DBAL\Driver\Connection;

class UserService
{
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function hasAccess(User $user, $permission)
    {
        return true;
    }

    public function getUserByEmail($email)
    {
        return null;
    }

    public function authenticate($email, $secret)
    {
        return true;
    }
}
