<?php

namespace App\Repository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\DBAL\Driver\Connection;
use App\Entity\User;
use App\Entity\PermissionsBag;

class PermissionService
{
    protected $session;
    protected $userService;

    public function __construct(SessionInterface $session, UserService $userService)
    {
        $this->session = $session;
        $this->userService = $userService;
    }

    public function can(string $permission)
    {
        // FIXME: Get logged-in user from session
        $permissionBag = $this->userService->getPermissionsByUser(2);
        return $permissionBag->has($permission);
    }

}
