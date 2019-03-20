<?php
/**
 * Created by PhpStorm.
 * User: Alexandre
 * Date: 19/03/2019
 * Time: 18:17
 */

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
     */
    public function showHangmanGame()
    {
        return $this->render("hangman.html.twig");
    }

}