<?php

namespace App\Controller;


use App\Entity\Qcm;
use App\Form\EditQcm;
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

        $user = $this->getUser();

        return $this->render('showQcms.html.twig', [
            "qcms" => $qcms,
            "user" => $user
        ]);
    }

    /**
     * @Route("editQcm/{idQcm}", name="editQcm")
     * @param $idQcm
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editQcm($idQcm)
    {
        $repositoryQcm = $this->getDoctrine()->getRepository(Qcm::class);
        $qcm = $repositoryQcm->find($idQcm);
        $user = $this->getUser();


        $form = $this->createForm(EditQcm::class, $qcm);

        return $this->render('qcm.edit.html.twig', ["editQcm" => $form->createView()]);

    }

}