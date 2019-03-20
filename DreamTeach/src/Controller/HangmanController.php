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

        return $this->render("hangman.html.twig", ["word" => $word]);
    }

    /**
     * @Route("checkWord", name="CheckWord")
     */
    public function checkWord(Request $request)
    {
        $session = $request->getSession();
        $word = $session->get("word");
        $response = new Response(json_encode(array(
            'word' => $word
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}