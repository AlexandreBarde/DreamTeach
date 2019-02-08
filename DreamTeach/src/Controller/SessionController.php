<?php
namespace App\Controller;


use App\Entity\Session;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\SessionFormType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class StudentController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class SessionController extends AbstractController
{

    /**
     * @Route("/nouvellesession", name="sessionCreation")
     */
    public function sessionCreation(Request $request)
    {
        $session= new Session();
        $form = $this->createForm(SessionFormType::class, $session);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $session->setOrganizerid($this->getUser());
            $em->persist($session);
            $em->flush();
        }
        return $this->render("sessionCreation.html.twig", ['formSessionCreation' => $form->createView()]);
    }
}