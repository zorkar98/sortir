<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModifyOutingController extends AbstractController
{
    #[Route('/modify/outing', name: 'app_modify_outing')]
    public function index(): Response
    {
        return $this->render('modify_outing/modifyprofil.html.twig', [
            'controller_name' => 'ModifyOutingController',
        ]);
    }
}
