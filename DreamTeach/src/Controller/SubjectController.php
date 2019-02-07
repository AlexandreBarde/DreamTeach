<?php

namespace App\Controller;

use App\Entity\School;
use App\Entity\Badge;
use App\Entity\Session;
use App\Entity\Student;
use App\Entity\Subject;
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
use Symfony\Component\Form\Extension\Core\Type\DateType;

class SubjectController extends AbstractController
{

    /**
     * @Route("/createSubject", name="createSubject")
     */
    public function createSubject(Request $request, ObjectManager $manager)
    {
        $subject = new Subject();
        $form = $this->createFormBuilder($subject)
            ->add('name')
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($subject);
            $manager->flush();
            return $this->redirectToRoute("profile", ['idStudent' => $this->getUser()->getId()]);

        }

        return $this->render("createSubject.html.twig", ["formSubject" => $form->createView()]);
    }
}