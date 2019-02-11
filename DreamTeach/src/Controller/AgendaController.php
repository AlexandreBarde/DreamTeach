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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class StudentController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class AgendaController extends AbstractController
{
    /**
     * @Route("accueil/agenda", name="student_agenda")
     */

    public function sessionAction()
    {
        $user = $this->getUser();
        return $this->render(
            "myAgenda.html.twig",
            [
                "user" => $user,
            ]
        );
    }
}