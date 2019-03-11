<?php

namespace App\Controller;


use App\Entity\FriendshipRelation;
use App\Entity\Message;
use App\Entity\Session;
use App\Entity\Student;
use App\Entity\Subject;
use App\Entity\Subjectlevel;
use App\Entity\Training;
use App\Form\ProfileFormType;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Query\ResultSetMapping;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


/**
 * Class StudentController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class StudentController extends AbstractController
{
    /**
     * @Route("/dashboard", name="default_student_connected")
     */

    public function homeStudentAction()
    {
        $tpm = array();
        $session = $this->getDoctrine()->getRepository(Session::class)->findall();
        $nbSessionOrganized = $this->getDoctrine()->getRepository(Session::class)->countNbSessionOrganizedByUser(
            $this->getUser()
        );

        /*calcul du nombre de sessions passées où l'étudiant a été inscrit*/
        $now = new DateTime("now");
        $now->format('Y-m-d');

        $listSessionAttended = $this->getUser()->getSessionid();
        $nbSessionAttended = 0;
        foreach ($listSessionAttended as $sessionAttended) {
            if ($sessionAttended->getDate() < $now) {
                $nbSessionAttended++;
            }
        }


        foreach ($session as $key => $value) {
            $now = new \DateTime();
            if ($value->getDate() > $now && sizeOf($tpm) < 3) {
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

        return $this->render("dashboard.html.twig", [
            'session' => $tpm,
            'sessionUser' => $listeSessionEtudiant,
            'nbSessionOrganized' => $nbSessionOrganized,
            'nbSessionAttended' => $nbSessionAttended,
            "messages" => $messagesTmp,
        ]);
    }

    /**
     * @Route("/search", name="search_student_view")
     */

    public function searchStudent(Request $request)
    {
        if ($request->get('search_student')) {
            $result_student = $this->getDoctrine()->getRepository(Student::class)->searchStudent(
                $request->get('search_student')
            );

            return $this->render(
                'friend.search.html.twig',
                [
                    'students' => $result_student
                ]
            );
        } else {
            return $this->redirectToRoute('default_student_connected');
        }
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
     * @Route("/mon-profil/", name="student_profile")
     */

    public function studentProfileAction(Request $request, ObjectManager $manager)
    {
        $subjectlevel = new Subjectlevel();


        $noteUser = $this->getDoctrine()->getRepository(Subjectlevel::class)->findBy([
            "studentid" => $this->getUser()->getId(),
        ]);
        $em = $this->getDoctrine()->getManager();

        $rsm = new ResultSetMapping();
        $RAW_QUERY = 'SELECT subject.name 
                                   FROM  subject 
                                   WHERE subject.id NOT IN 
                                    (SELECT subjectlevel.subjectid
                                    FROM subjectlevel  
                                    WHERE subjectlevel.studentid = :id )';
        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->bindValue('id', $this->getUser()->getId());
        $statement->execute();
        $subjectNotInfo = $statement->fetchAll();
        $avatar = $this->getUser()->getavatar();


        if ($request->getMethod() == 'POST') {
            if (!is_null($request->request->get('editer'))) {
                $repository = $this->getDoctrine()->getRepository(Student::class);

                /** @var Training $formations */

                $user = $this->getUser();
                $studentId = $repository->find($this->getUser()->getId());

                $form = $this->createForm(ProfileFormType::class, $user);

                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {


                    $file = $studentId->getAvatar();
                    if ($file != null) {

                        $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                        try {
                            $file->move(
                                $this->getParameter('avatar_directory'),
                                $fileName
                            );
                        } catch (FileException $e) {
                            // TODO Gérer les erreurs
                        }
                        $user->setAvatar($fileName);

                    } else {

                        $studentId->setavatar($avatar);
                    }


                    $manager->persist($user);
                    $manager->flush();

                    return $this->redirectToRoute("student_profile");

                }

                return $this->render("updateProfile.html.twig", ["formUser" => $form->createView(), "user" => $this->getUser()]);

            } else if (!is_null($request->request->get('matieres'))) {
                $repository = $this->getDoctrine()->getRepository(Subject::class);
                $subject = new Subject();
                $form = $this->createFormBuilder($subject)
                    ->add('name')
                    ->getForm();

                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    if ($repository->findBy(
                        ['name' => $form->get('name')->getData()]
                    )) {

                    } else {
                        $manager->persist($subject);
                        $manager->flush();

                        return $this->redirectToRoute("student_profile");
                    }
                }

                return $this->render("informASubject.html.twig", ["formSubject" => $form->createView()]);
            }

        }

        return $this->render(
            "viewProfile.html.twig",
            ['user' => $this->getUser(), 'noteUser' => $noteUser, "subjectNotInfo" => $subjectNotInfo]
        );
    }

    /**
     * @Route("/profil/{uuid_student}", name="student_other_profile")
     */
    public function studentOtherProfileAction($uuid_student)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->findOneBy(
            [
                'uuid' => $uuid_student,
            ]
        );
        $user = $this->getUser();
        if (!$student) {
            return $this->redirectToRoute("default_student_connected");
        } elseif ($uuid_student == $this->getUser()->getUuid()) {
            return $this->redirectToRoute('student_profile');
        }
        $waiting_for_accept = false;
        $is_friend = false;
        $are_not_unknow = false;
        $are_not_unknow = $this->getDoctrine()->getRepository(FriendshipRelation::class)->checkIfAreUnknow(
            $user,
            $student
        );

        if ($are_not_unknow) {
            $waiting_for_accept = $this->getDoctrine()->getRepository(FriendshipRelation::class)->checkIfNotAccepted(
                $user,
                $student
            );

            $is_friend = $this->getDoctrine()->getRepository(FriendshipRelation::class)->checkIfAreFriend(
                $user,
                $student
            );
        }
        $noteUser = $this->getDoctrine()->getRepository(Subjectlevel::class)->findBy(
            [
                "studentid" => $student,

            ]);

        return $this->render(
            'viewOtherProfile.html.twig',
            [
                'noteUser' => $noteUser,
                'student' => $student,
                'are_not_unknow' => $are_not_unknow,
                'waiting_for_accept' => $waiting_for_accept,
                'is_friend' => $is_friend
            ]
        );
    }

    /**
     * @Route("/createSubject", name="createSubject")
     */
    public function createSubject(Request $request, ObjectManager $manager)
    {

    }

    /**
     * @Route("/informASubject", name="informASubject")
     */
    public function informASubject(Request $request, ObjectManager $manager)
    {


    }

    public function sessionAction()
    {

    }

    /**
     * @Route("/classementxp", name="classementXp")
     */
    public function classementXp(){
        $classement = $this->getDoctrine()->getEntityManager();
        $tags = $classement->getRepository(Student::class)->findBy(
            array(), array('xpwon' => 'DESC')
        );

        return $this->render(
            'classementxp.html.twig',
            [
                'classementxp' => $tags
            ]
        );

    }
}