<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StudentController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class FriendController extends AbstractController
{
    /**
     * @param Request $request
     * @Route("/liste-ami", name="friend_list")
     */
    public function listFriendController(Request $request)
    {
        return $this->render('friend.list.html.twig', [

        ]);
    }
}