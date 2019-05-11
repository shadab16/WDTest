<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\UserService;

class GuestController extends AbstractController
{
    private $session;
    private $userService;

    public function __construct(SessionInterface $session, UserService $userService)
    {
        $this->session = $session;
        $this->userService = $userService;
    }

    public function index()
    {
        return $this->render('guest.html.twig');
    }

    public function access(Request $request)
    {
        $user = $this->userService->getUserByEmail($request->get('email'));
        $this->session->set('userId', $user->getUserId());
        return $this->redirectToRoute('post_list');
    }
}