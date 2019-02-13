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
     * Permet d'afficher les derniers messages reçus de l'utilisateur
     * @Route("showMessages", name="ShowMessages")
     */
    public function showMessages()
    {
        // On récupère tous les messages que l'utilisateur a reçu
        $messages = $this->getDoctrine()->getRepository(Message::class)->findByStudent($this->getUser()->getId());
        $messagesTmp = array();
        $arrayIdSender = array();
        // On parcourt les messages
        foreach ($messages as $m)
        {
            // Si l'ID de la personne qui a envoyé le message n'est pas dans le tableau
            if(!( in_array($m->getIdSender()->getId(), $arrayIdSender)))
            {
                array_push($arrayIdSender,$m->getIdSender()->getId());
                array_push($messagesTmp, $m);
            }
        }
        // Retourne les derniers messages que l'utilisateur a reçu
        return $this->render("messages.html.twig", ["messages" => $messagesTmp]);
    }

    /**
     * @Route("showConversation", name="ShowConversation")
     */
    public function showConversation()
    {
        $messages = $this->getDoctrine()->getRepository(Message::class)->findByStudent($this->getUser()->getId());
        return $this->render("conversation.html.twig");
    }


}