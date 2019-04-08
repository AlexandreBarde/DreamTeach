<?php
/**
 * Created by PhpStorm.
 * User: claurenc
 * Date: 06/02/2019
 * Time: 11:21
 */

namespace App\Controller;

use App\Entity\Memory;
use App\Entity\Sessionparticipants;
use App\Entity\Student;
use App\Entity\Training;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Word;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class StudentController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class MemoryController extends AbstractController
{
    /**
     * @Route("/games/memory", name="memory")
     */
    public function memoryAction(Request $request)
    {
        $session = $request->getSession();
        if(!($session->get('nbGoodAnswer'))) {
            $session->set('nbGoodAnswer', 0);
        }
        $session = $request->getSession();
        $words = $this->getDoctrine()->getRepository(Word::class)->findAll();
        if(sizeof($words) > 5) {
            $words = array_slice($words, 0, 5);
        }
        $wordsDefinition = $words;
        if($request->get('clickedCard1')) {
            if($request->get('clickedCard1') == $request->get('clickedCard2')) {
                $session->set('nbGoodAnswer', $session->get('nbGoodAnswer') + 1);
                $response = new Response(json_encode(array(
                    'goodAnswer' => true,
                    'nbGoodAnswer' => $session->get('nbGoodAnswer')
                )));
                $response->headers->set('Content-Type', 'application/json');
                return $response;
            }
        }
        if($request->get('counter')) {
            $scoreMemory = new Memory();
            $scoreMemory->setStudentId($this->getUser());
            $scoreMemory->setTime($request->get('counter'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($scoreMemory);
            $em->flush();
            $response = new Response(json_encode(array(
                'message' => 'Votre score a été enregistré ! Temps: ' . $request->get('counter') . ' secondes.'
            )));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        shuffle($words);
        shuffle($wordsDefinition);
        return $this->render(
            "memory.html.twig",
            [
                "words" => $words,
                "wordsDefinition" => $wordsDefinition
            ]
        );
    }
}