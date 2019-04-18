<?php

namespace App\Controller;


use App\Entity\Badge;
use App\Entity\FileUpload;
use App\Entity\MarkingNotation;
use App\Entity\Session;
use App\Entity\Sessioncomment;
use App\Entity\Student;
use App\Entity\Subject;
use App\Form\AddCommentSessionFormType;
use App\Form\AddMarkingNotationFormType;
use App\Form\SessionFormType;
use App\Form\SubjectType;
use App\Form\TransferSessionRightsFormType;
use App\Form\UploadFile;
use App\Repository\SearchStudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class StudentController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class SessionController extends Controller
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
                $badge = $this->getDoctrine()->getRepository(Badge::class)->find(1);
                $this->get('ajout_badge')->addBadge($this->getUser(), $badge);
                /* Ajout de l'xp  */
                $this->get('xp_won')->wonXp($this->getUser(), 25);

                return $this->redirectToRoute('AddSession', ["idSession" => $id]);

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
        //seances a venir
        $listSessionAVenir = array();
        $listSessionTerminees= array();

        $allSessions = $this->getDoctrine()->getRepository(Session::class)->findall();

        $em = $this->getDoctrine()->getManager();
        foreach ($allSessions as $key => $value) {
            $now = new \DateTime();
            if ($value->getDate() >= $now) {
                array_push($listSessionAVenir, $value);
            } else {
                array_push($listSessionTerminees, $value);
                $value->setClosed(true);
                $em->flush();

            }
        }

        $currentStudent = $this->getUser();
        $sessionUserList=$currentStudent->getSessionid();
        $sessionUser=array();

        foreach ($sessionUserList as $session) {
            // On ajoute les séances
            array_push($sessionUser, $session->getId());
        }


        //seance "je suis le createur"
        $sessionWhereStudentCreator= array();

        foreach ($listSessionAVenir as $key => $value){
            if ($value->getOrganizerId()->getId()==$currentStudent->getId()){
                array_push($sessionWhereStudentCreator, $value);
            }
        }

        $historiqueSession= array();
        foreach($listSessionTerminees as $key => $value){
            $listParticipants=$value->getStudentId();
            foreach($listParticipants as $student){
                if ($student->getId()==$currentStudent->getId()){
                   array_push($historiqueSession, $value);
                }
            }
        }

        return $this->render("showSessions.html.twig", [
            'sessionToCome' => $listSessionAVenir,
            'sessionWhereStudentCreator' => $sessionWhereStudentCreator,
            'historiqueSession'=> $historiqueSession,
            'currentStudent' => $currentStudent,
            'sessionUser' => $sessionUser
        ]);
    }

    /**
     * @Route("/displaySession/{session}", name="displaySession")
     * @param $idSession
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function displaySession(Request $request, Session $session)
    {
        $comment = new Sessioncomment();
        $sessionComment = $this->createForm(AddCommentSessionFormType::class, $comment);

        $allSessionComments = $this->getDoctrine()->getRepository(Sessioncomment::class)->findBy(array('idSession' => $session));
        $sessionComment->handleRequest($request);

        $averageMarkingAmbience = $this->getDoctrine()->getRepository(MarkingNotation::class)->getMarkingAmbienceAverage(
            $session);
        $averageMarkingEfficiency = $this->getDoctrine()->getRepository(MarkingNotation::class)->getMarkingEfficiencyAverage(
            $session);

        $markingNotationForm = $this->createForm(
            AddMarkingNotationFormType::class,
            $markingNotation = new MarkingNotation()
        );
        $markingNotationForm->handleRequest($request);

        if ($sessionComment->isSubmitted() && $sessionComment->isValid()) {
            if ($this->getDoctrine()->getRepository(Sessioncomment::class)->findBy(array('idSession' => $session, 'idStudent' => $this->getUser()->getId()))) {
                $this->addFlash('success', "Commentaire non envoyé car vous avez déjà envoyé un commentaire pour cette session");

                return $this->redirectToRoute("displaySession", ["session" => $session]);
            } else {
                $em = $this->getDoctrine()->getManager();
                $comment->setIdSession($session);
                $comment->setIdStudent($this->getUser());
                $this->addFlash('success', "Commentaire envoyé !");

                $em->persist($comment);
                $em->flush();

                return $this->redirectToRoute("displaySession", ["session" => $session->getId()]);
            }
        }

        if ($markingNotationForm->isSubmitted() && $markingNotationForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $markingNotation->setSession($session);
            $markingNotation->setStudent($this->getUser());

            $em->persist($markingNotation);
            $em->flush();

            return $this->redirectToRoute("displaySession", ["session" => $session->getId()]);
        }

        $userHasAlreadyMarked = $this->getDoctrine()->getRepository(MarkingNotation::class)->findOneBy([
            'student' => $this->getUser(),
            'session' => $session
        ]);

        return $this->render("displaySession.html.twig", [
            'allSessionComments' => $allSessionComments,
            'session' => $session,
            'formComment' => $sessionComment->createView(),
            'formMarking' => $markingNotationForm->createView(),
            'userHasAlreadyMarked' => $userHasAlreadyMarked,
            'averageAmbience' => $averageMarkingAmbience,
            'averageEfficiency' => $averageMarkingEfficiency
        ]);
    }

    /**
     * @Route("/delete-participant/{session}/{student}", name="delete_participant_in_session")
     */

    public function deleteParticipant(Request $request, Session $session, Student $student)
    {
        if ($session->getOrganizerid() != $this->getUser()) {
            $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $session->removeStudentid($student);
        $em->flush();

        return $this->redirectToRoute('displaySession', [
            'session' => $session->getId()
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

    /**
     * @Route("/addFile/{session}", name="AddFile")
     * @param Request $request
     * @param Session $session
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addFile(Request $request, Session $session)
    {
        if($this->getUser() == $session->getOrganizerid())
        {
            $fileUp = new FileUpload();
            $form = $this->createForm(UploadFile::class, $fileUp);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid())
            {
                /** @var UploadedFile $file */
                $file = $form->get('filename')->getData();
                dump($file);
                $filename = str_replace(".pdf", "", $file->getClientOriginalName()) . '_' . $this->generateUniqueFileName() . '.' . $file->guessExtension();
                try
                {
                    $file->move(
                        $this->getParameter('file_directory'),
                        $filename
                    );
                    $this->addFlash("success", "Fichier ajouté !");
                    $fileUp->setFilename($filename);
                    $fileUp->setIdSession($session);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($fileUp);
                    $em->flush();
                } catch (FileException $e) {}
            }
            return $this->render("uploadfile.html.twig", ['form' => $form->createView(), 'session' => $session]);
        }
        else
        {
            $this->addFlash("alert", "Vous n'avez pas la permission d'ajouter un fichier !");
            return $this->redirectToRoute("showSessions");
        }
    }

    /**
     * @Route("/removeFile/{idFile}", name="RemoveFile")
     * @param FileUpload $idFile
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeFile(FileUpload $idFile)
    {
        if($this->getUser() == $idFile->getIdSession()->getOrganizerid())
        {
            $this->addFlash("success", "Fichier supprimé !");
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($idFile);
            $entityManager->flush();
        }
        else
        {
            $this->addFlash("alert", "Vous n'avez pas la permission de supprimer ce fichier !");
        }
        return $this->redirectToRoute("AddFile", ["session" => $idFile->getIdSession()->getId()]);
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }


    /**
     * @Route("/searchSession", name="search_session")
     */
    public function searchSession(Request $request)
    {
        if ($request->get('search_session')) {
            $result_session = $this->getDoctrine()->getRepository(Session::class)->searchSession(
                $request->get('search_session')
            );
            return $this->render(
                'showSessions.html.twig',
                [
                    'sessionSearch' => $result_session,
                ]
            );
        } else {
            return $this->redirectToRoute('default_student_connected');
        }
    }


}