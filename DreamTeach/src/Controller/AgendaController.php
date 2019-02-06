<?php
/**
 * Created by PhpStorm.
 * User: claurenc
 * Date: 06/02/2019
 * Time: 11:21
 */

namespace App\Controller;

use App\Entity\Student;
use App\Entity\Training;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StudentController
 * @package App\Controller
 * @Route("/dashboard")
 * @IsGranted("ROLE_USER")
 */
class AgendaController
{
    /**
     * @Route("/accueil/agenda", name="agenda")
     */

    public function homeAgendaAction()
    {
        return $this->render("myAgenda.html.twig");
    }
}