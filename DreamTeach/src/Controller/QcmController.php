<?php

namespace App\Controller;


use App\Entity\Qcm;
use App\Form\CreateQcmType;
use App\Form\EditQcm;
use App\Service\QcmService;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     * @param $idQcm
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editQcm(Request $request, $idQcm, ObjectManager $manager)
    {
        $repositoryQcm = $this->getDoctrine()->getRepository(Qcm::class);
        $qcm = $repositoryQcm->find($idQcm);
        $user = $this->getUser();
        dump($qcm);
        $form = $this->createForm(EditQcm::class, $qcm);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->flush();
            $manager->persist($qcm);
        }
        return $this->render('qcm.edit.html.twig', ["editQcm" => $form->createView()]);
    }

    /**
     * Permet de générer un QCM
     * @Route("/initQcm", name="createQcm")
     */
    public function initQcm(Request $request, QcmService $qcmService)
    {
        $qcm = $qcmService->initQcm($this->getUser());

        return $this->redirectToRoute(
            'createQcm2',
            [
                'id' => $qcm,
            ]
        );
    }

    /**
     * @Route("/createQcm/{id}", name="createQcm2")
     */
    public function createQcm(Request $request, Qcm $qcm)
    {
        $user = $this->getUser();
        $formQcm = $this->createForm(CreateQcmType::class, $qcm);
        $formQcm->handleRequest($request);

        if ($formQcm->isSubmitted() && $formQcm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $data = $formQcm->getData();
            $questions = $data->getQuestions();

            foreach ($questions as $q) {
                $responses = $q->getResponses();
                $q->setAuthor($user);
                $q->setQcm($qcm);
            }

            $qcm->setAuthorId($user);
            $em->persist($qcm);
            $em->flush();

            dump($qcm);exit;
            return $this->redirectToRoute('showQcms');
        }

        return $this->render(
            'qcm.create.html.twig',
            [
                'formCreateQcm' => $formQcm->createView(),
            ]
        );
    }
}