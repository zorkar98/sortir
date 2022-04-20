<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfilFormType;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class ModifyProfilController extends AbstractController
{
    #[Route('/modifyprofil', name: 'app_modifyprofil')]
    public function editProfil(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        UserAuthenticatorInterface $userAuthenticator,
        AppAuthenticator $authenticator,
        EntityManagerInterface $entityManager
    ): Response
        {
            $newProfil = new User();
            $profilForm = $this->createForm(ProfilFormType::class, $newProfil);
            $profilForm->handleRequest($request);
            $newProfil->setAdministrator(false);
            $newProfil->setActive(true);

            if ($profilForm->isSubmitted() && $profilForm->isValid()) {
                $newProfil->setPassword(
                    $userPasswordHasher->hashPassword(
                        $newProfil,
                        $profilForm->get('plainPassword')->getData()
                    )
                );


            $entityManager->persist($newProfil);
            $entityManager->flush();

            return $userAuthenticator->authenticateUser(
                $newProfil,
                $authenticator,
                $request
            );
        }

        return $this->render('modifyprofil/modifyprofil.html.twig', [
            'profilForm'=> $profilForm->createView(),
        ]);

    }

}
