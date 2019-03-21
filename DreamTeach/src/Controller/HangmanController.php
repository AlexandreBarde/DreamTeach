<?php
/**
 * Created by PhpStorm.
 * User: Alexandre
 * Date: 19/03/2019
 * Time: 18:17
 */

namespace App\Controller;

use App\Entity\Word;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class MessageController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class HangmanController extends AbstractController
{

    /**
     * @Route("hangman", name="PlayHangman")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showHangmanGame(Request $request)
    {
        //$this->getUser()->setAttribute("word", "toto");

        $words = $this->getDoctrine()->getRepository(Word::class);

        $random = rand(1, sizeof($words->findAll()));

        $word = $words->findOneBy(['id' => $random]);

        dump($word);

        $session = $request->getSession();

        $session->set("word", $word);
        $session->set("life", 15);

        return $this->render("hangman.html.twig", ["word" => $word]);
    }

    /**
     * @Route("checkWord", name="CheckWord")
     * @param Request $request
     * @return Response
     */
    public function checkWord(Request $request)
    {
        $session = $request->getSession();

        $word = $session->get("word");
        $life = $session->get("life");

        $char = $request->request->get("char");

        if (strpos($word->getWord(), $char) !== false) $state = true;
        else
        {
            $state = false;
            if($life >= 1) $session->set("life", $life - 1);
            else
            {
                //c'est perdu
            }
        }


        $response = new Response(json_encode(array(
            'word' => $state,
            'life' => $life - 1
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}