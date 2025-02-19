<?php

namespace App\Controller;

use App\Entity\Habitude;
use App\Form\HabitudeType;
use App\Repository\HabitudeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    public function index(Request $request, EntityManagerInterface $entityManager, HabitudeRepository $habitudeRepository): Response
    {
        $habitude = new Habitude();
        $form = $this->createForm(HabitudeType::class, $habitude);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $habitude->setDateCreation(new \DateTime());
            $entityManager->persist($habitude);
            $entityManager->flush();

            return $this->redirectToRoute('app_accueil');
        }

        $habitudes = $habitudeRepository->findAll();

        return $this->render('accueil/accueil.html.twig', [
            'habitudes' => $habitudes,
            'form' => $form->createView(),
        ]);
    }
}
