<?php

namespace App\Controller;


use App\Entity\Session;
use App\Entity\Student;
use App\Entity\Subject;
use App\Entity\Badge;
use App\Entity\Sessioncomment;
use App\Form\AddCommentSessionFormType;
use App\Form\SubjectType;
use App\Form\TransferSessionRightsFormType;
use DateTime;
use DateTimeZone;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Form\SessionFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Collection;

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
    public function sessionCreationAndUpdate(Request $request, $idSession = null)
    {
        $session = new Session();
        $subject = new Subject();
        if ($idSession != null) {
            $session = $this->getDoctrine()->getRepository(Session::class)->find($idSession);
        }

        $form = $this->createForm(SessionFormType::class, $session);
        $formSubject = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);
        $formSubject->handleRequest($request);

        if ($formSubject->isSubmitted() && $formSubject->isValid()) {
            $this->addFlash("success", "La matière a été créée avec succès");
            $em = $this->getDoctrine()->getManager();
            $em->persist($subject);
            $em->flush();
            return $this->render("sessionCreation.html.twig", ['formSessionCreation' => $form->createView(), 'formSubjectCreation' => $formSubject->createView()]);

        }
        if ($form->isSubmitted() && $form->isValid()) {

            if (($form->get('endingTime')->getData()) > ($form->get('startingTime')->getData())) {
                $this->addFlash("success", "La session a bien été créée");
                $em = $this->getDoctrine()->getManager();
                $session->setOrganizerid($this->getUser());
                $session->setClosed(false);
                $em->persist($session);
                $em->flush();
                $id = $session->getId();
                /* Ajout du badge  */
                $badge = $this->getDoctrine()->getRepository(Badge::class)->find(1);
                $this->get('ajout_badge')->addBadge($this->getUser(), $badge);
                /* Ajout de l'xp  */
                $this->get('xp_won')->wonXp($this->getUser(), 50);
                return $this->redirectToRoute('AddSession', ["idSession" => $id]);

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
        foreach ($listeSession as $sessionTMP) {
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
    public function displaySession($idSession, Request $request)
    {
        $comment = new Sessioncomment();
        $session = $this->getDoctrine()->getRepository(Session::class)->find($idSession);
        $sessionComment = $this->createForm(AddCommentSessionFormType::class, $comment);

        $allSessionComments = $this->getDoctrine()->getRepository(Sessioncomment::class)->findBy(array('idSession' => $idSession));
        $sessionComment->handleRequest($request);
        if ($sessionComment->isSubmitted() && $sessionComment->isValid()) {
            if ($this->getDoctrine()->getRepository(Sessioncomment::class)->findBy(array('idSession' => $idSession, 'idStudent' => $this->getUser()->getId()))) {
                $this->addFlash('success', "Commentaire non envoyé car vous avez déjà envoyé un commentaire pour cette session");
                return $this->redirectToRoute("displaySession", ["idSession" => $idSession]);
            } else {
                $em = $this->getDoctrine()->getManager();
                $comment->setIdSession($session);
                $comment->setIdStudent($this->getUser());
                $this->addFlash('success', "Commentaire envoyé !");

                $em->persist($comment);
                $em->flush();
                return $this->redirectToRoute("displaySession", ["idSession" => $idSession]);
            }
        }
        return $this->render("displaySession.html.twig", [
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
        if ($idSession != null) {
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
        if ($idSession != null) {
            $referer = $r->headers->get('referer');
            $refererSplitted = explode("/", $referer);
            $path = $refererSplitted[sizeof($refererSplitted) - 1];
            /** @var Session $session */
            $session = $this->getDoctrine()->getRepository(Session::class)->find($idSession);
            $em = $this->getDoctrine()->getManager();
            $session->setClosed(true);
            $em->persist($session);
            $em->flush();
            if ($path === "showSessions") return $this->redirectToRoute("showSessions");
            else if ($path === "agenda") return $this->redirectToRoute("student_agenda");
        }
        return $this->redirectToRoute("student_agenda");
    }

    /**
     * @Route("/accueil/transferRights/{session}", name="transferRights")
     * @param Request $request
     * @param Session $session
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function transferSessionRights(Request $request, Session $session)
    {
        $participants = $session->getStudentid();
        $participantsWithoutAdmin = new ArrayCollection();
        foreach ($participants as $participant) {
            if ($participant != $this->getUser()) {
                $participantsWithoutAdmin->add($participant);
            }
        }


        if($participantsWithoutAdmin->isEmpty()){
            $this->addFlash('danger', "Pas encore de participants pour cette séance...");
            return $this->redirectToRoute("showSessions");
        }

        $form = $this->createForm(TransferSessionRightsFormType::class, $session, [
            'participants' => $participantsWithoutAdmin
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $newOrganizer = $form->get("organizerid")->getData();

            $em = $this->getDoctrine()->getManager();
            $session->setOrganizerid($newOrganizer);
            $this->addFlash('success', "Droits d'administrateur transmis");
            $em->flush();

            return $this->redirectToRoute("showSessions");

        }

        return $this->render("transferSessionRights.html.twig", ['session' => $session, 'form' => $form->createView()]);


    }


}