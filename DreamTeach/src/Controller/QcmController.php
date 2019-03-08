<?php

namespace App\Controller;


use App\Entity\Qcm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MessageController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class QcmController extends AbstractController
{

    /**
     * Permet d'afficher tous les QCMS disponibles
     * @Route("showQcms", name="showQcms")
     */
    public function showQcm()
    {
        $repositoryQcms = $this->getDoctrine()->getRepository(Qcm::class);

        $qcms = $repositoryQcms->findBy(['visible' => '1']);

        return $this->render('showQcms.html.twig', [
            "qcms" => $qcms
        ]);
    }

}