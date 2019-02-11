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
     * @Route("/accueil/updateSession/{idSession}", name="updateSession")
     * @param $idSession
     */
    public function sessionCreationAndUpdate(Request $request, $idSession=null)
    {
        $session = new Session();
        if ($idSession!=null) {
            $session = $this->getDoctrine()->getRepository(Session::class)->find($idSession);
        }

        $form = $this->createForm(SessionFormType::class, $session);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {


            if (($form->get('endingTime')->getData()) > ($form->get('startingTime')->getData())) {

                $em = $this->getDoctrine()->getManager();
                $session->setOrganizerid($this->getUser());
                $em->persist($session);
                $em->flush();
                return $this->redirectToRoute('student_agenda');
            } else {

                $this->addFlash("error", "L'heure de fin ne peut pas être infériere à l'heure de début.");
                return $this->redirectToRoute('sessionCreationAndUpdate');

            }
        }
        return $this->render("sessionCreation.html.twig", ['formSessionCreation' => $form->createView()]);
    }


}