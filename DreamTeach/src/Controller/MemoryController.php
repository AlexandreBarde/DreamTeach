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
     * @Route("games/memory", name="memory")
     */

    public function sessionAction()
    {
        $words = $this->getDoctrine()->getRepository(Word::class)->findAll();
        return $this->render(
            "memory.html.twig",
            [
                "words" => $words,
            ]
        );
    }
}