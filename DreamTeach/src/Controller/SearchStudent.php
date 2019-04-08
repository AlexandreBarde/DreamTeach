<?php
/**
 * Created by PhpStorm.
 * User: Alexandre
 * Date: 03/04/2019
 * Time: 18:50
 */

namespace App\Controller;


use App\Entity\Student;
use App\Repository\SearchStudentRepository;
use App\Repository\StudentRepository;
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

        foreach($students as $key => $value)
        {
            array_push($nom, $value->getFirstName() . " " . $value->getLastName());
        }

        $response = new Response(json_encode(array(
            'student' => $nom,
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}