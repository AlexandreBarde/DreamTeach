<?php

namespace App\Controller;

use App\Entity\FriendshipRelation;
use App\Entity\Student;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StudentController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class FriendController extends AbstractController
{
    /**
     * @param Request $request
     * @Route("/liste-ami", name="friend_list")
     */
    public function listFriendController(Request $request)
    {
        return $this->render('friend.list.html.twig', [

        ]);
    }

    /**
     * @Route("/add/{uuid_student}", name="add_friend")
     */
    public function addFriend($uuid_student)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->findOneBy(
            [
                'uuid' => $uuid_student,
            ]
        );
        $user = $this->getUser();
        if (!$student) {
            return $this->redirectToRoute("default_student_connected");
        } elseif ($uuid_student == $user->getUuid()) {
            return $this->redirectToRoute('default_student_connected');
        }

        $em = $this->getDoctrine()->getManager();
        $relationShip = new FriendshipRelation();

        $relationShip->setStudent1($user);
        $relationShip->setStudent2($student);
        $em->persist($relationShip);
        $em->flush();

        $this->addFlash('success', "La demande d'ami a été effectué avec succés");

        return $this->redirectToRoute(
            'student_other_profile',
            [
                'uuid_student' => $uuid_student,
            ]
        );
    }
}