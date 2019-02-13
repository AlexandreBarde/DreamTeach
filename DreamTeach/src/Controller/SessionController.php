<?php

namespace App\Controller;


use App\Entity\Session;
use App\Entity\Subject;
use App\Entity\Sessioncomment;

use App\Form\AddCommentSessionFormType;
use App\Form\SubjectType;
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
        $subject = new Subject();
        if ($idSession!=null) {
            $session = $this->getDoctrine()->getRepository(Session::class)->find($idSession);
        }

        $form = $this->createForm(SessionFormType::class, $session);
        $formSubject = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);
        $formSubject->handleRequest($request);

        if($formSubject->isSubmitted() && $formSubject->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($subject);
            $em->flush();
            return $this->render("sessionCreation.html.twig", ['formSessionCreation' => $form->createView(), 'formSubjectCreation' => $formSubject->createView()]);

        }
        if ($form->isSubmitted() && $form->isValid()) {

            if (($form->get('endingTime')->getData()) > ($form->get('startingTime')->getData())) {

                $em = $this->getDoctrine()->getManager();
                $session->setOrganizerid($this->getUser());
                $session->setClosed(false);
                $em->persist($session);
                $em->flush();
                $id=$session->getId();
                return $this->redirectToRoute('AddSession', ["idSession"=>$id]);

                return $this->redirectToRoute('student_agenda');
            } else {

                $this->addFlash("error", "L'heure de fin ne peut pas être infériere à l'heure de début.");
                return $this->redirectToRoute('sessionCreation');

            }
        }
        return $this->render("sessionCreation.html.twig", ['formSessionCreation' => $form->createView(), 'formSubjectCreation' => $formSubject->createView()]);
    }

    /**
     * @Route("showSessions", name="showSessions")
     */
    public function showSessions()
    {
        $tpm = array();
        $session = $this->getDoctrine()->getRepository(Session::class)->findall();

        foreach ($session as $key => $value) {
            $now = new \DateTime();
            if ($value->getDate() >= $now) {
                array_push($tpm, $value);
            }
        }

        $student = $this->getUser();
        /** @var Session $listeSession */
        $listeSession = $student->getSessionid();

        $tmp = array();
        $listeSessionEtudiant = array();

        // On parcourt les séances auxquelles l'utilisateur est déjà inscrit
        foreach($listeSession as $sessionTMP) {
            // On ajoute les séances
            array_push($tmp, $sessionTMP->getId());
        }

        foreach ($tmp as $ss) {
            // On ajoute les ID des sessions
            array_push($listeSessionEtudiant, $ss);
        }

        return $this->render("showSessions.html.twig", [
            'session' => $tpm,
            'sessionUser' => $listeSessionEtudiant
        ]);
    }

    /**
     * @Route("/accueil/displaySession/{idSession}", name="displaySession")
     * @param $idSession
     */
    public function displaySession($idSession, Request $request){
        $comment = new Sessioncomment();
        $session = $this->getDoctrine()->getRepository(Session::class)->find($idSession);
        $sessionComment = $this->createForm(AddCommentSessionFormType::class, $comment);

        $allSessionComments = $this->getDoctrine()->getRepository(Sessioncomment::class)->findBy(array('idSession' => $idSession));
        $sessionComment->handleRequest($request);
        if($sessionComment->isSubmitted() && $sessionComment->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $comment->setIdSession($session);
            $comment->setIdStudent($this->getUser());
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute("displaySession", ["idSession" => $idSession]);
        }
        return $this->render("displaySession.html.twig",[
            'allSessionComments' => $allSessionComments,
            'session' => $session,
            'formComment' => $sessionComment->createView()
        ]);
    }

    /**
     * @Route("/accueil/deleteSession/{idSession}", name="deleteSession")
     * @param $idSession
     */
    public function deleteSession($idSession)
    {
        // TODO : Vérifier que l'utilisateur est bien le créateur
        if ($idSession!=null)
        {
            $session = $this->getDoctrine()->getRepository(Session::class)->find($idSession);
            $em = $this->getDoctrine()->getManager();
            $em->remove($session);
            $em->flush();
            return $this->redirectToRoute('student_agenda');
        }
    }

    /**
     * @Route("/accueil/closeSession/{idSession}", name="CloseSession")
     * @param $idSession
     * @param Request $r
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function closeSession($idSession, Request $r)
    {
        if($idSession != null)
        {
            $referer = $r->headers->get('referer');
            $refererSplitted = explode("/", $referer);
            $path = $refererSplitted[sizeof($refererSplitted) - 1];
            /** @var Session $session */
            $session = $this->getDoctrine()->getRepository(Session::class)->find($idSession);
            $em = $this->getDoctrine()->getManager();
            $session->setClosed(true);
            $em->persist($session);
            $em->flush();
            if($path === "showSessions") return $this->redirectToRoute("showSessions");
            else if($path === "agenda") return $this->redirectToRoute("student_agenda");
        }
        return $this->redirectToRoute("student_agenda");
    }


}