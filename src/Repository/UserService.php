<?php

namespace App\Repository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\DBAL\Driver\Connection;
use App\Entity\User;
use App\Entity\PermissionsBag;

class UserService
{
    protected $connection;
    protected $session;

    public function __construct(Connection $connection, SessionInterface $session)
    {
        $this->connection = $connection;
        $this->session = $session;
    }

    public function hasAccess(string $permission): boolean
    {
        return $this->getPermissionsByUser(1)
            ->has($permission);
    }

    public function userHasAccess(string $userId, string $permission): boolean
    {
        return $this->getPermissionsByUser($userId)
            ->has($permission);
    }

    public function getUserByEmail(string $email): User
    {
        return null;
    }

    public function authenticate(string $email, string $secret): User
    {
        return true;
    }

    public function getPermissionsByUser(string $userId): PermissionsBag
    {
        $stmt = $this->connection->prepare('
            select permission.name from user
            left join user_roles on (user.user_id = user_roles.user_id)
            left join roles_permissions on (user_roles.role_id = roles_permissions.role_id)
            left join permission on (roles_permissions.permission_id = permission.permission_id)
            where user.user_id = ?
        ');
        $stmt->bindValue(1, $userId);
        $stmt->execute();
        $records = array_column($stmt->fetchAll(), 'name');
        return new PermissionsBag($records);
    }
}
