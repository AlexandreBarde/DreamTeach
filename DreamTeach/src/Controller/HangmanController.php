<?php
/**
 * Created by PhpStorm.
 * User: Alexandre
 * Date: 19/03/2019
 * Time: 18:17
 */

namespace App\Controller;

use App\Entity\Hangman;
use App\Entity\Word;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Badge;

/**
 * Class MessageController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class HangmanController extends Controller
{
    /**
     * @Route("/hangman", name="PlayHangman")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showHangmanGame(Request $request)
    {
        if($request->get('counter')) {
            $scoreHangman = new Hangman();
            $scoreHangman->setStudent($this->getUser());
            $scoreHangman->setTime($request->get('counter'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($scoreHangman);
            $em->flush();
            $response = new Response(json_encode(array(
                'message' => 'Votre score a été enregistré ! Temps: ' . $request->get('counter') . ' secondes.'
            )));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        $words = $this->getDoctrine()->getRepository(Word::class);

        $random = rand(1, sizeof($words->findAll()));

        /** @var Word $word */
        $word = $words->findOneBy(['id' => $random]);

        $session = $request->getSession();

        $session->set("word", strtolower($word->getWord()));
        $session->set("definition", $word->getDefinition());
        $session->set("life", 11);
        $session->set("compteur", strlen($word->getWord()));

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
        $definitionWord = $session->get("definition");
        $compteur = $session->get("compteur");
        $life = $session->get("life");
        $definition = null;
        $winner = false;

        $char = strtolower($request->request->get("char"));

        $position = array();

        if (strpos($word, $char) !== false)
        {
            $state = true;
            $wordArray = str_split($word);
            for($i = 0; $i < strlen($word); $i++)
            {
                if($wordArray[$i] == $char)
                {
                    array_push($position,$i);
                    $compteur--;
                }
            }
        }
        else
        {
            $state = false;
            if($life == 10) $definition = $definitionWord;
            if($life >= 1) $session->set("life", $life - 1);
            else
            {
                //c'est perdu
                //TODO : Redirect view avec le mot qui devait être trouvé (perdu : le mot était xxx)
            }
        }

        $session->set("compteur", $compteur);

        if($compteur == 0)
        {
            $session->set("winner", true);
            $winner = true;
        }

        $response = new Response(json_encode(array(
            'word' => $state,
            'life' => $life - 1,
            'definition' => $definition,
            'position' => $position,
            'letter' => $char,
            'winner' => $winner
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("hangmanWinner", name="HangmanWinner")
     * @param Request $request
     * @return Response
     */
    public function winner(Request $request)
    {
        $session = $request->getSession();
        if($session->get('winner'))
        {
            $session->set("winner", false);
            $badge = $this->getDoctrine()->getRepository(Badge::class)->find(4);
            $this->get('ajout_badge')->addBadge($this->getUser(), $badge);
            $this->get('xp_won')->wonXp($this->getUser(),10);
            return $this->render("hangman.winner.html.twig", ["word" => $session->get("word")]);
        }
        else
        {
            return $this->render("hangman.cheater.html.twig");
        }
    }

}