<?php
/**
 * Created by PhpStorm.
 * User: claurenc
 * Date: 06/02/2019
 * Time: 11:21
 */

namespace App\Controller;

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

    public function sessionAction(Request $request)
    {
        $words = $this->getDoctrine()->getRepository(Word::class)->findAll();
        if($request->get('clickedCard1')) {
            if($request->get('clickedCard1') == $request->get('clickedCard2')) {
                $response = new Response(json_encode(array(
                    'goodAnswer' => true
                )));
                $response->headers->set('Content-Type', 'application/json');
                return $response;
            }
        }
        $shuffled_array = array();
        $shuffled_keys = array_keys($words);
        shuffle($shuffled_keys);

        foreach($shuffled_keys as $shuffled_key) {
            $shuffled_array[$shuffled_key] = $words[$shuffled_key];
        }
        return $this->render(
            "memory.html.twig",
            [
                "words" => $shuffled_array,
            ]
        );
    }
}