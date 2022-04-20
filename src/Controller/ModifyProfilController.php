<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfilFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModifyProfilController extends AbstractController
{
    #[Route('/modifyprofil', name: 'app_modifyprofil')]
    public function index(
        Request $request,
    ): Response
    {
        $newProfil = new User();
        $profilForm = $this->createForm(ProfilFormType::class, $newProfil );

        $profilForm->handleRequest($request);
        if($profilForm->isSubmitted() && $profilForm->isValid())
            {
                $em = $this->getDoctrine()->getManager();
            }

        return $this->render('modifyprofil/modifyprofil.html.twig', [
            ['profilForm'=> $profilForm->createView()]
        ]);
    }




}
