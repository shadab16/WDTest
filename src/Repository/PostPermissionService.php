<?php

namespace App\Repository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\DBAL\Driver\Connection;
use App\Entity\User;
use App\Entity\PermissionsBag;
use App\Entity\Permission;
use App\Entity\Post;

class PostPermissionService
{
    protected $session;
    protected $permissionService;
    
    public function __construct(SessionInterface $session, PermissionService $permissionService)
    {
        $this->session = $session;
        $this->permissionService = $permissionService;
    }

    private function getCurrentUserId()
    {
        $loggedUserId = $this->session->get('userId');
        return $loggedUserId;
    }

    public function canViewAny()
    {
        return $this->permissionService->can(Permission::$VIEW_ANY_POST);
    }

    public function canEditAny()
    {
        return $this->permissionService->can(Permission::$EDIT_ANY_POST);
    }

    public function canDeleteAny()
    {
        return $this->permissionService->can(Permission::$DELETE_ANY_POST);
    }

    public function canView(Post $post)
    {
        return $this->canViewAny() ||
            $post->getAuthorId() == $this->getCurrentUserId();
    }

    public function canEdit(Post $post)
    {
        return $this->canEditAny() ||
            $post->getAuthorId() == $this->getCurrentUserId();
    }

    public function canDelete(Post $post)
    {
        return $this->canDeleteAny() ||
            $post->getAuthorId() == $this->getCurrentUserId();
    }

}
