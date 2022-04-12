<?php

namespace App\Controller;

use App\Repository\OutingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class OutingController extends AbstractController
{
    #[Route('/outing/list', name: 'app_list')]
        public function outing(OutingRepository $outingRepository
        ):Response
        {
            $outings = $outingRepository->findAll();

            return $this->render('outing/index.html.twig', [
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
                throw $this-> createNotFoundException('Aucune sortie n\'a été trouvée');
            }
            return $this->render('outing/detail.html.twig',
            compact('outing'));
    }

    #[Route ('outing/create', name : 'app_create')]
    public function create(
        EntityManagerInterface $em,
        Request $request,
        MailerInterface $mailer,
        Mail $mail,
        Censurator $censurator
    ):Response
    {
        $outing = new Outing();
        $outingForm = $this->createForm(OutingType::class, $outing);

        $outingForm->handleRequest($request);
        if($outingForm->isSubmitted() && $outingForm->isValid())
            {
                $outing->setIsPublished(true);
                $outing->setDateCreated(2);

                $namePurify = $censurator->purify($outing->getName());

                $outing->setOutingInfo($censurator->purify($outing->getOutingInfo()));

                $em->persist($outing);
                $em->flush();

                $mail->send();

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
