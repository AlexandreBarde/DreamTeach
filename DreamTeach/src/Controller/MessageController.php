<?php

namespace App\Controller;
use App\Entity\Message;
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
        $messages = $this->getDoctrine()->getRepository(Message::class)->findByStudent($this->getUser()->getId());
        //$messages = $repository
            //->findBy(array('idReceiver' => $this->getUser()->getId())
        //);
        //$messages = $repository->findByIdReceiver($this->getUser()->getId());
        $messagesTmp = array();
        $arrayIdSender = array();
        foreach ($messages as $m)
        {
            if( !( in_array($m->getIdSender()->getId(), $arrayIdSender) ) )
            {
                array_push($arrayIdSender,$m->getIdSender()->getId());
                array_push($messagesTmp, $m);
            }
        }
        return $this->render("messages.html.twig", ["messages" => $messagesTmp]);
    }

    /**
     * @Route("showConversation", name="ShowConversation")
     */
    public function showConversation()
    {

    }


}