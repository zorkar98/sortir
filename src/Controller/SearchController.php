<?php

namespace App\Controller;

use App\Entity\Campus;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
   // public function index(): Response
    /*{
        return $this->render('search/outingByCampus.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }

    public function SearchCampus (Request $request)
    {
        return $this->render('search/outingByCampus.html.twig');
    }*/




    public function ChoiceCampus (FormBuilderInterface $lookCampus){

        $lookCampus->add('Campus', EntityType::class, [
            // looks for choices from this entity
            'class' => Campus::class

        ]);

    }

}
