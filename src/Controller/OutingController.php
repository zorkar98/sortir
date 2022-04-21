<?php

namespace App\Controller;

use App\Entity\Outing;
use App\Form\OutingType;
use App\Form\ProfilFormType;
use App\Repository\CampusRepository;
use App\Repository\OutingRepository;
use App\Repository\UserRepository;
use App\Security\AppAuthenticator;
use ContainerBZtjxxQ\getMaker_PhpCompatUtilService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;


class OutingController extends AbstractController
{
    #[Route('/outing/list', name: 'app_list')]
        public function outing(
            OutingRepository $outingRepository,
            CampusRepository $campusRepository,
            Request          $request,
        ):Response
        {

            //On recupere les filtres
            $filters = $request -> get("campus");

            //On va chercher les sorties en fonction du filtre
            $outings = $outingRepository->getOuting($filters);

            //On va chercher toutes les catégories
            $campus = $campusRepository->findAll();

            //On vérifie si on a un requete ajax
            if($request->get('ajax')){
                return new JsonResponse([
                    'content' => $this->renderView('outing/_content.html.twig',
                        compact("outings"))
                ]);
            }

            return $this->render('outing/list.html.twig',
                compact("outings","campus"));
        }

    #[Route('outing/detail/{id}', name: 'app_detail')]
        public function detail(
            $id = 1,
            OutingRepository $outingRepository
        ):Response
        {
            $outing = $outingRepository->find($id);
                if(!$outing) {
                    throw $this-> createNotFoundException('Oops ! Nothing here !');
                }
                return $this->render('outing/detail.html.twig',
                compact('outing'));
        }

    #[Route ('outing/create', name : 'app_create')]
    public function create(
        EntityManagerInterface $em,
        UserRepository $userRepository,
        Request $request,
        MailerInterface $mailer,
    ):Response
    {
        $outing = new Outing();
        $outingForm = $this->createForm(OutingType::class, $outing);

        $outingForm->handleRequest($request);
        if($outingForm->isSubmitted() && $outingForm->isValid())
            {
                $currentUser = $userRepository->findOneBy(['username' => $this->getUser()->getUserIdentifier()]);
                $outing->setAuthor($currentUser->getUsername());
                $outing->setState('Created');
                $outing->setDateCreated(new \DateTime());
                //$outing->setIsPublished(true);

                //$namePurify = $censurator->purify($outing->getName());

                //$outing->setOutingInfo($censurator->purify($outing->getOutingInfo()));

                $em->persist($outing);
                $em->flush();

                //$mail->send();

                $this->addFlash(
                    'congrats',
                    'Congratulations ! Let\'s get ready to the Raaaaamble ! \o/ ');
                return $this->redirectToRoute('app_detail',
                    ["id" => $outing->getId()]
                );
            }
        return $this->render(
            'outing/create.html.twig',
            ['outingForm' => $outingForm->createView()]

        );
    }

    #[Route('/outing/{outing}/registration/', name: 'app_outing_registration')]
    public function outingAddParticipants(
        Outing $outing,
        UserRepository $userRepository,
        EntityManagerInterface $entityManagerInterface,
    ): Response
    {
        $user = $userRepository->findOneBy(['username' => ($this->getUser()->getUserIdentifier())]);
        $outing->addParticipants($user->getUsername());

        $entityManagerInterface->persist($outing);
        $entityManagerInterface->flush($outing);
        return $this->redirectToRoute('app_list');

    }


    #[Route('/outing/{outing}/unregistration/', name: 'app_outing_unregistration')]
    public function outingRemoveParticipants(
        Outing $outing,
        UserRepository $userRepository,
        EntityManagerInterface $entityManagerInterface,
    ): Response
    {
        $user = $userRepository->findOneBy(['username' => ($this->getUser()->getUserIdentifier())]);
        $outing->removeParticipants($user->getUsername());

        $entityManagerInterface->persist($outing);
        $entityManagerInterface->flush($outing);
        return $this->redirectToRoute('app_list');
    }


    #[Route('/modifyouting{id}', name: 'app_modifyouting')]
    public function editOuting(
        $id,
        Request $request,
        EntityManagerInterface $entityManager

    ): Response
    {
        $outing = $entityManager->getRepository(Outing::class)->find($id);
        $outingForm = $this->createForm(OutingType::class, $outing);

        $outingForm->handleRequest($request);


        if ($outingForm->isSubmitted() && $outingForm->isValid()) {

            $entityManager->persist($outing);
            $entityManager->flush();

            return $this->redirectToRoute('app_list');
        }

        return $this->render('/modifyouting/modifyouting.html.twig', [
            'outingForm'=> $outingForm->createView(),
        ]);

    }
}
