<?php

namespace App\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class MessageController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class MessageController extends AbstractController
{

    /**
     * @Route("showMessages", name="ShowMessages")
     */
    public function showMessages()
    {
        return $this->render("messages.html.twig");
    }

}