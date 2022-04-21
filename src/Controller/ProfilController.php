<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {
        return $this->render('profil/profil.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }

    #[Route('/profil/{username}', name: 'app_profil_other')]
    public function otherProfil(
    UserRepository $userRepository,
    String         $username
    ): Response
    {
        $user = $userRepository->findOneBy(
            ['username' => $username]
        );

        return $this->render('profil/profilother.html.twig',[
            'controller_name'=> 'ProfilController',
            'user' => $user
        ]);
    }

}
