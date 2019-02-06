<?php
/**
 * Created by PhpStorm.
 * User: Adel
 * Date: 04/02/2019
 * Time: 10:21
 */

namespace App\Controller;

use App\Entity\School;
use App\Entity\Student;
use App\Entity\Training;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProfileController extends AbstractController
{

    /**
     * @Route("/profile/{idStudent}", name="profileView")
     */
    public function getInfoStudent($idStudent)
    {
        $reqUser = $this->getDoctrine()->getRepository(Student::Class);
        $user = $reqUser->find($idStudent);

        if ($idStudent == $this->getUser()->getId()) {
            return $this->redirectToRoute('myProfile');
        }
        return $this->render("viewProfile.html.twig", ["user" => $user, "isCurrentUser" => $this->getUser()->getId() == $user->getId()]);
    }

    /**
     * @Route("/profile", name="myProfile")
     */
    public function getInfoCurrentStudent()
    {
        $reqUser = $this->getDoctrine()->getRepository(Student::Class);
        $user = $reqUser->find($this->getUser()->getId());

        return $this->render("viewProfile.html.twig", ["user" => $user, "isCurrentUser" => $this->getUser()->getId() == $user->getId()]);
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
                    'choice_value' => function($formations) {
                        return $formations->getTitle();
                    }
                ]
            )
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute("myProfile", ["user" => $user]);
        }
        return $this->render("updateProfile.html.twig", ["formUser" => $form->createView()]);
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

}