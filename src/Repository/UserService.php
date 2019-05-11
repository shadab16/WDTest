<?php

namespace App\Repository;
use Doctrine\DBAL\Driver\Connection;
use App\Entity\User;
use App\Entity\PermissionsBag;

class UserService
{
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public static function create(string $userId, string $name, string $email, string $passwordHash): User
    {
        $user = new \App\Entity\User();
        return $user->setUserId($userId)
            ->setName($name)
            ->setEmail($email)
            ->setPasswordHash($passwordHash);
    }

    public function getUserById(string $userId): User
    {
        $stmt = $this->connection->prepare('select * from user where user_id = ?');
        $stmt->bindValue(1, $userId);
        $stmt->execute();
        $record = $stmt->fetch();
        if (empty($record))
        {
            throw new \RangeException('Unable to find user with the given ID');
        }
        return self::create($record['user_id'], $record['name'], $record['email'], $record['password_hash']);
    }

    public function getUserByEmail(string $email): User
    {
        $stmt = $this->connection->prepare('select * from user where email = ?');
        $stmt->bindValue(1, $email);
        $stmt->execute();
        $record = $stmt->fetch();
        if (empty($record))
        {
            throw new \RangeException('Unable to find user with the given email');
        }
        return self::create($record['user_id'], $record['name'], $record['email'], $record['password_hash']);
    }

    public function authenticate(string $email, string $secret): User
    {
        $user = $this->getUserByEmail($email);
        return password_verify($secret, $user->getPasswordHash());
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
