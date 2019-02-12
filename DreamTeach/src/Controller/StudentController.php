<?php

namespace App\Controller;


use App\Entity\Session;
use App\Entity\Student;
use App\Entity\Subject;
use App\Entity\Subjectlevel;
use App\Entity\Training;
use App\Form\ProfileFormType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


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

        foreach ($session as $key => $value) {
            $now = new \DateTime();
            if ($value->getDate() > $now) {
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

        return $this->render("dashboard.html.twig", [
            'session' => $tpm,
            'sessionUser' => $listeSessionEtudiant,
            'nbSessionOrganized' => $nbSessionOrganized
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
        $noteUser = $this->getDoctrine()->getRepository(Subjectlevel::class)->findBy([
            "studentid" => $this->getUser()->getId(),
        ]);
        if($request->getMethod() == 'POST') {
            if (!is_null($request->request->get('editer'))) {
                $repository = $this->getDoctrine()->getRepository(Student::class);
                $training = $this->getDoctrine()->getRepository(Training::class);
                /** @var Training $formations */
                $formations = $training->findBySchoolid($this->getUser()->getTrainingid()->getSchoolid());
                $user = $this->getUser();
                $studentId = $repository->find($this->getUser()->getId());

                $form = $this->createFormBuilder($user)
                    ->add('firstName', TextType::class, [
                        'attr' => [
                            'class' => 'form-control']
                    ])
                    ->add('lastName', TextType::class, [
                        'attr' => [
                            'class' => 'form-control']
                    ])
                    ->add('biography', TextType::class, [
                        'attr' => [
                            'class' => 'form-control']
                    ])
                    ->add('emailAddress', TextType::class, [
                    'attr' => [
                        'class' => 'form-control']
                    ])
                    ->add('trainingID', ChoiceType::class, [
                        'choices' => $formations,
                        'attr' => [
                            'class' => 'form-control'],
                        'choice_label' => function($choiceValue, $key, $value) {
                            return $choiceValue->getTitle();
                        }
                    ])
                    ->add('birthDate', DateType::class, [
                        'widget' => 'single_text',
                        'attr' => [
                            'class' => 'form-control'],
                        'format' => 'yyyy-MM-dd'
                    ])
                    ->add('avatar', FileType::class, [
                        'attr' => [
                            'class' => 'form-control']
                    ])
                    ->add('city', TextType::class, [
                    'attr' => [
                        'class' => 'form-control']
                    ])
                    ->getForm();

                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $file = $studentId->getAvatar();
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
                    $manager->persist($user);
                    $manager->flush();

                    return $this->redirectToRoute("student_profile");

                }

                return $this->render("updateProfile.html.twig", ["formUser" => $form->createView(), "user" => $this->getUser()]);

            } else if(!is_null($request->request->get('matieres'))) {
                $repository = $this->getDoctrine()->getRepository(Subject::class);
                $subject = new Subject();
                $form = $this->createFormBuilder($subject)
                    ->add('name')
                    ->getForm();

                $form->handleRequest($request);

                if($form->isSubmitted() && $form->isValid()) {
                    if($repository->findBy(
                        ['name' => $form->get('name')->getData()]
                    )) {

                    } else {
                        $manager->persist($subject);
                        $manager->flush();

                        return $this->redirectToRoute("student_profile");
                    }
                }

                return $this->render("createSubject.html.twig", ["formSubject" => $form->createView()]);
            }

        }

        return $this->render(
            "viewProfile.html.twig",
            ['user' => $this->getUser(), 'noteUser' => $noteUser]
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
        if (!$student) {
            return $this->redirectToRoute("default_student_connected");
        } elseif ($uuid_student == $this->getUser()->getUuid()) {
            return $this->redirectToRoute('student_profile');
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
            ]
        );
    }

    /**
     * @Route("/createSubject", name="createSubject")
     */
    public function createSubject(Request $request, ObjectManager $manager)
    {

    }

    public function sessionAction()
    {

    }
}