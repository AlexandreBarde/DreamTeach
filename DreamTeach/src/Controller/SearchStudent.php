<?php
/**
 * Created by PhpStorm.
 * User: Alexandre
 * Date: 03/04/2019
 * Time: 18:50
 */

namespace App\Controller;


use App\Entity\Session;
use App\Entity\Student;
use App\Repository\SearchStudentRepository;
use App\Repository\StudentRepository;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SearchStudent extends AbstractController
{

    /**
     * @Route("/accueil/searchStudent", name="SearchStudent")
     * @param Request $request
     * @return Response
     */
    public function SearchStudent(Request $request)
    {
        $char = strtolower($request->request->get("char"));

        $students = $this->getDoctrine()->getRepository(Student::class)->findStudentWithChar($char);

        $nom = array();
        $id = array();

        foreach($students as $key => $value)
        {
            array_push($nom, $value->getFirstName() . " " . $value->getLastName());
            array_push($id, $value->getUuid());
        }

        $response = new Response(json_encode(array(
            'student' => $nom,
            'id' => $id
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/accueil/shareSession/{idSession}/{uuidUser}", name="ShareSession")
     * @param $idSession
     * @param $uuidUser
     * @param \Swift_Mailer $mailer
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     */
    public function shareSession($idSession, $uuidUser, \Swift_Mailer $mailer)
    {
        $session = $this->getDoctrine()->getRepository(Session::class)->find($idSession);
        /** @var Student $user */
        $user = $this->getDoctrine()->getRepository(Student::class)->findOneByUuid($uuidUser);


        EmailService::sendMail($user->getEmailaddress(), "Invitation à rejoindre une séance", $this->renderView("mail.sharesession.html.twig", ["session" => $session, "user" => $user]), $mailer);

        return $this->render("mail.sharesession.html.twig", ["session" => $session, "user" => $user]);
    }

}