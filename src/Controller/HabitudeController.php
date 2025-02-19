<?php

namespace App\Controller;

use App\Entity\Habitude;
use App\Entity\Utilisateur;
use App\Form\HabitudeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HabitudeController extends AbstractController
{
    #[Route('/habitudes', name: 'app_habitudes')]
    public function index(): Response
    {
        $habitudes = $this->getUser()->getHabitudes();

        return $this->render('habitude/index.html.twig', [
            'habitudes' => $habitudes,
        ]);
    }

    #[Route('/habitude/ajouter', name: 'app_habitude_ajouter')]
    public function ajouter(Request $request, EntityManagerInterface $entityManager): Response
    {
        $habitude = new Habitude();
        $form = $this->createForm(HabitudeType::class, $habitude);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $habitude->setCreateur($this->getUser());
            $habitude->setGroupe($this->getUser()->getGroupeFromUser());
            $habitude->setDateCreation(new \DateTime());

            $entityManager->persist($habitude);
            $entityManager->flush();

            $this->addFlash('success', 'Habitude ajoutée avec succès !');

            return $this->redirectToRoute('app_habitudes');
        }

        return $this->render('habitude/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
