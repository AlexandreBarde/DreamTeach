<?php
/**
 * Created by PhpStorm.
 * User: boehmhugo
 * Date: 2019-04-08
 * Time: 10:50
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GameController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class GameController extends AbstractController
{
    /**
     * Permet d'afficher les jeux
     * @Route("/showGames", name="ShowGames")
     */
    public function showgame() {
        return $this->render("showGames.html.twig");
    }

}