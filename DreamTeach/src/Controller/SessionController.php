<?php
namespace App\Controller;


use App\Entity\Session;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Types\DateType;
use Doctrine\DBAL\Types\TextType;
use Doctrine\DBAL\Types\TimeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\SessionFormType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class SessionController extends AbstractController
{

    /**
     * @Route("accueil/sessionCreation", name="sessionCreation")
     */
    public function sessionCreation(Request $request)
    {
        $session= new Session();
        $form = $this->createForm(SessionFormType::class, $session);
        $form->handleRequest($request);

        return $this->render("sessionCreation.html.twig", ['formSessionCreation' => $form->createView()]);
    }
}