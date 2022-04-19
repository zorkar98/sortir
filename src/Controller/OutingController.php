<?php

namespace App\Controller;

use App\Entity\Outing;
use App\Form\OutingType;
use App\Repository\OutingRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class OutingController extends AbstractController
{
    #[Route('/outing/list', name: 'app_list')]
        public function outing(OutingRepository $outingRepository
        ):Response
        {
            $outings = $outingRepository->findAll();
            dump($outings);

            return $this->render('outing/list.html.twig', [
                'controller_name' => 'OutingController',
            ]);
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
