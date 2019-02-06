<?php

namespace App\Controller;

use App\Entity\School;
use App\Entity\Badge;
use App\Entity\Student;
use App\Entity\Training;
use App\Form\UploadPicture;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProfileController extends AbstractController
{

    /**
     * @Route("/profile/{idStudent}", name="profile")
     */
    public function getInfoStudent($idStudent)
    {
        $user = $this->getDoctrine()->getRepository(Student::Class)->find($idStudent);
        $userTraining = $this->getDoctrine()->getRepository(Training::class)->findOneById(
            [
                "id" => $user->getTrainingid(),
            ]
        );
        $schoolUser = $this->getDoctrine()->getRepository(School::class)->findOneBy([
            "id" => $userTraining->getSchoolid(),
        ]);
        $badgeUser = $this->getDoctrine()->getRepository(Badge::class)->findBy([
            "id" => $user->getId(),
        ]);
        // $noteUser = $this->getDoctrine()->getRepository(Subject::class)->findOneBy([
        //     "idStudent" => $user->getStudentid(),
        //     "idTraining" => $user->getTrainingid(),
        // ]);

        return $this->render(
            "viewProfile.html.twig",
            [
                "user" => $user,
                "userTraining" => $userTraining,
                "schoolUser" => $schoolUser,
                "badgeUser" => $badgeUser,
                "isCurrentStudent" => $this->getUser()->getId() == $idStudent,
                'idStudent' => $idStudent
            ]
        );
    }

    /**
     * @Route("/updateInfosProfile", name="updateInfosProfile")
     */
    public function updateProfile(Request $request, ObjectManager $manager)
    {
        $training = $this->getDoctrine()->getRepository(Training::class);
        /** @var Training $formations */
        $formations = $training->findBySchoolid($this->getUser()->getTrainingid()->getSchoolid());
        $user = $this->getUser();

        $form = $this->createFormBuilder($user)
            ->add('firstName')
            ->add('lastName')
            ->add('biography')
            ->add('emailAddress')
            ->add('trainingID', ChoiceType::class, [
                    'choices' => $formations,
                ]
            )
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();
        }
        return $this->render("updateProfile.html.twig", ["formUser" => $form->createView(), "user" => $user]);
    }

    /**
     * @Route("/deleteProfile", name="deleteProfile")
     * @IsGranted("ROLE_USER")
     */
    public function deleteProfile()
    {
        $repository = $this->getDoctrine()->getRepository(Student::class);
        $user = $repository->find($this->getUser()->getId());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->render("empty.html.twig");
    }

    /**
     * @Route("/accueil/uploadPicture", name="uploadPicture")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function uploadPicture(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Student::class);
        /** @var Student $user */
        $student = $repository->find($this->getUser()->getId());

        $form = $this->createForm(UploadPicture::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            
            /** @var UploadedFile $file */
            $file = $student->getAvatar();
            $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

            try
            {
                $file->move(
                    $this->getParameter('avatar_directory'),
                    $fileName
                );
            }
            catch (FileException $e)
            {
                // TODO Gérer les erreurs
            }

            $student->setAvatar($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();

            return $this->redirect($this->generateUrl('HomeController'));

        }

        return $this->render(
            "uploadPicture.html.twig",
            [
                'form' => $form->createView(),
                'user' => $this->getUser(),
            ]
        );
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

}