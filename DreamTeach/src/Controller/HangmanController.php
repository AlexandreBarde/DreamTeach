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

        /** @var Word $word */
        $word = $words->findOneBy(['id' => $random]);

        dump($word);

        $session = $request->getSession();

        $session->set("word", strtolower($word->getWord()));
        $session->set("life", 15);

        $wordRender = "";

        $sizeWord = strlen($word->getWord());
        for($i = 0; $i < $sizeWord; $i++)
        {
            $wordRender .= "_";
        }

        return $this->render("hangman.html.twig", ["word" => $wordRender]);
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
        $definition = null;

        $char = strtolower($request->request->get("char"));

        $position = array();

        if (strpos($word, $char) !== false)
        {
            $state = true;
            $wordArray = str_split($word);
            for($i = 0; $i < strlen($word); $i++)
            {
                if($wordArray[$i] == $char) array_push($position,$i);
            }
        }
        else
        {
            $state = false;
            if($life == 10) $definition = $word->getDefinition();
            if($life >= 1) $session->set("life", $life - 1);
            else
            {
                //c'est perdu
                //TODO : Redirect view avec le mot qui devait être trouvé (perdu : le mot était xxx)
            }
        }

        $response = new Response(json_encode(array(
            'word' => $state,
            'life' => $life - 1,
            'definition' => $definition,
            'position' => $position,
            'letter' => $char
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}