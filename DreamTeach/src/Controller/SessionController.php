<?php
namespace App\Controller;


use Doctrine\Common\Persistence\ObjectManager;
use http\Env\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{

    /**
     * @Route("accueil/sessionCreation", name="sessionCreation")
     */
    public function sessionCreation(Request $request, ObjectManager $manager)
    {
        $session= new Session();
        $form=$this->createFormBuilder($session)
            ->add('sessionName')
            ->add('subject')
            ->add('description')
            ->add('startingTime')
            ->add('endingTime')
            ->add('date')
            ->add('isVirtual')
            ->add('numberMaxOfParticipant')
            ->add('vocalSoftware')
            ->add('city')
            ->add('place')

        return $this->render("sessionCreation.html.twig");
    }
}