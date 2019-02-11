<?php

namespace App\Controller;


use App\Entity\Session;

use DateTime;
use DateTimeZone;
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
        $session = new Session();
        $form = $this->createForm(SessionFormType::class, $session);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {


            if (($form->get('endingTime')->getData()) > ($form->get('startingTime')->getData())) {

                $em = $this->getDoctrine()->getManager();
                $session->setOrganizerid($this->getUser());
                $em->persist($session);
                $em->flush();
            } else {

                $this->addFlash("error", "L'heure de fin ne peut pas être infériere à l'heure de début.");
                return $this->redirectToRoute('sessionCreation');

            }
        }
        return $this->render("sessionCreation.html.twig", ['formSessionCreation' => $form->createView()]);
    }
}