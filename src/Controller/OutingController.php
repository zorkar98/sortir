<?php

namespace App\Controller;

use App\Entity\Outing;
use App\Form\OutingType;
use App\Repository\CampusRepository;
use App\Repository\OutingRepository;
use App\Repository\UserRepository;
use ContainerBZtjxxQ\getMaker_PhpCompatUtilService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;


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




}
