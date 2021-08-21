<?php

namespace App\Controller;

use App\Repository\ParameterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(ParameterRepository $parameterRepository): Response
    {
        $firstUse = $parameterRepository->findFirst();
        if ($firstUse) {
            if ($firstUse->getFirstUse()) {
                echo("First use");
            }else{
                echo ("Found but is false");
            }
        }
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
