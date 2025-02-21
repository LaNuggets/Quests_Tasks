<?php

namespace App\Controller;

use App\Entity\Habitude;
use App\Entity\Utilisateur;
use App\Form\HabitudeType;
use App\Entity\Invitation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HabitudeController extends AbstractController
{
    #[Route('/tableau_de_bord', name: 'app_habitudes')]
    public function index(): Response
    {
        $user = $this->getUser();

        if($user == null){
            return $this->redirectToRoute('app_connexion');
        }else{
            $groupe = $user->getGroupe();
            $habitudes = $groupe->getHabitudes();

            return $this->render('twig/index.html.twig', [
                'habitudes' => $habitudes,
                'user' => $user,
                'groupe' => $groupe,
            ]);
        }
    }

    #[Route('/habitude/ajouter', name: 'app_habitude_ajouter')]
    public function ajouter(Request $request, EntityManagerInterface $entityManager): Response
    {
        $habitude = new Habitude();
        $form = $this->createForm(HabitudeType::class, $habitude);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $habitude->setCreateur($this->getUser());
            $habitude->setGroupe($this->getUser()->getGroupe());
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

    #[Route('/delete_task/{id}', name: 'app_delete_task', methods: ['POST'])]
    public function delete_task(int $id, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $habitude = $entityManager->getRepository(Habitude::class)->find($id);

        $entityManager->remove($habitude);
        $entityManager->flush();

        return $this->redirectToRoute('app_habitudes');
        }

        #[Route('/valid_task/{id}', name: 'app_valid_task', methods: ['POST'])]
    public function valid_task(int $id, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $habitude = $entityManager->getRepository(Habitude::class)->find($id);

        $groupe = $habitude->getGroupe();

        $habitudeDif = $habitude->getDifficulte();

        $point = 0;
        switch($habitudeDif){
        case 'très facile':
            $point = 1;
            break;
        case 'facile':
            $point = 2;
            break;
        case 'moyen':
            $point = 5;
            break;
        case 'difficile':
            $point = 10;
            break;
        }
        
        $groupe->setScore($groupe->getScore() + $point);

        $entityManager->persist($habitude);
        $entityManager->persist($groupe);
        $entityManager->flush();

        return $this->redirectToRoute('app_habitudes');
        }
}
