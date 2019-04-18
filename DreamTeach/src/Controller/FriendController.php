<?php

namespace App\Controller;

use App\Entity\FriendshipRelation;
use App\Entity\Student;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Badge;

/**
 * Class StudentController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class FriendController extends Controller
{
    /**
     * @param Request $request
     * @Route("/friendList", name="friend_list")
     */
    public function listFriendController(Request $request)
    {
        $user = $this->getUser();
        $waitingAcceptations = $this->getDoctrine()->getRepository(FriendshipRelation::class)->findBy(
            [
                'student_2' => $user,
                'is_accepted' => 0,
        ]);

        $friendsAccepted = $this->getDoctrine()->getRepository(FriendshipRelation::class)->findBy(
            [
            'student_1' => $user,
            'is_accepted' => 1,
        ]);

        $friendsAccepted2 = $this->getDoctrine()->getRepository(FriendshipRelation::class)->findBy(
            [
                'student_2' => $user,
                'is_accepted' => 1,
            ]
        );

        return $this->render('friend.list.html.twig', [
            'waitingAcceptations' => $waitingAcceptations,
            'friendsAccepted' => $friendsAccepted,
            'friendsAccepted2' => $friendsAccepted2,
        ]);
    }

    /**
     * @Route("/accept/{student1}/{student2}/{id}/{uuid}", name="accept_friend")
     */

    public function acceptFriend($student1, $student2, $id, $uuid)
    {
        $user = $this->getUser();
        $relation = $this->getDoctrine()->getRepository(FriendshipRelation::class)->findOneBy(
            [
                'student_1' => $student1,
                'student_2' => $student2,
                'id' => $id,
                'is_accepted' => 0,
            ]
        );

        if (!$relation || $user->getId() != $student2 || $user->getUuid() != $uuid) {
            return $this->redirectToRoute('friend_list');
        }
        $em = $this->getDoctrine()->getManager();
        $relation->setIsAccepted(1);
        $em->persist($relation);
        $em->flush();

        return $this->redirectToRoute('friend_list');
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
        $badge = $this->getDoctrine()->getRepository(Badge::class)->find(3);
        $this->get('ajout_badge')->addBadge($this->getUser(),$badge);

        return $this->redirectToRoute(
            'student_other_profile',
            [
                'uuid_student' => $uuid_student,
            ]
        );
    }

    /**
     * @Route("/likeProfile/{uuid_student}", name="likeProfile")
     */
    public function likeProfile($uuid_student){


        $student = $this->getDoctrine()->getRepository(Student::class)->findOneBy(
            [
                'uuid' => $uuid_student,
            ]
        );


        $em = $this->getDoctrine()->getManager();
        $this->getUser()->addStudentid($student);
        $em->persist($this->getUser());
        $em->flush();


        return $this->redirectToRoute(
            'student_other_profile',
            [
                'uuid_student' => $uuid_student,
            ]
        );

    }

    /**
     * @Route("/unlikeProfile/{uuid_student}", name="unlikeProfile")
     */
    public function unlikeProfile($uuid_student){


        $student = $this->getDoctrine()->getRepository(Student::class)->findOneBy(
            [
                'uuid' => $uuid_student,
            ]
        );


        $em = $this->getDoctrine()->getManager();
        $list=$this->getUser()->getStudentid();
        foreach ($list as $studentinlist){
            if ($studentinlist=$student){
               $list->removeElement($studentinlist);
            }
        }

        $em->persist($this->getUser());
        $em->flush();


        return $this->redirectToRoute(
            'student_other_profile',
            [
                'uuid_student' => $uuid_student,
            ]
        );

    }

    /**
     * @Route("/delete/{id_user}/{id_friend}", name="delete_friend")
     */

    public function deleteFriends($id_user, $id_friend)
    {
        $user = $this->getUser();
        if ($user->getId() != $id_user) {
            $this->redirectToRoute('default_student_connected');
        }
        $relation = $this->getDoctrine()->getRepository(FriendshipRelation::class)->findOneBy(
            [
                'student_1' => $user->getId(),
                'student_2' => $id_friend,
                'is_accepted' => 1,
            ]
        );
        $relation2 = $this->getDoctrine()->getRepository(FriendshipRelation::class)->findOneBy(
            [
                'student_1' => $id_friend,
                'student_2' => $user->getId(),
                'is_accepted' => 1,
            ]
        );

        $are_friend = $relation || $relation2;
        if ($are_friend) {
            $em = $this->getDoctrine()->getManager();
            if ($relation) {
                $em->remove($relation);
            } elseif ($relation2) {
                $em->remove($relation2);
            } else {
                $this->redirectToRoute('default_student_connected');
            }
        }

        $em->flush();
        $this->addFlash('info', "Suppression réussie.");

        return $this->redirectToRoute('friend_list');
    }
}