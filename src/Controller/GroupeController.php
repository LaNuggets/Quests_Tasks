<?php

namespace App\Controller;

use App\Entity\Groupe;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class GroupeController extends AbstractController {
    
    #[Route('/groupe/{id}', name:'app_groupe')]
    public function getGroupData(EntityManagerInterface $entityManager, int $id){
        $user = $this->getUser();

        if($user->getGroupeFromUser() == null){
            return $this->redirectToRoute('app_create_groupe');
        }
        //        $groupeInvitation = $user.getInvitation();
        $groupe = $entityManager->getRepository(Groupe::class)->find($id);
        return $this->render('twig/group.html.twig', ['groupe' => $groupe]);
    }

    #[Route('/groupe/{groupeId}/ajouter-utilisateur', name: 'app_groupe_ajouter_utilisateur', methods: ['POST'])]
    public function ajouterUtilisateur(int $groupeId, Request $request, EntityManagerInterface $entityManager): Response
    {
        $groupe = $entityManager->getRepository(Groupe::class)->find($groupeId);

        if (!$groupe) {
            $this->addFlash('error', 'Groupe introuvable.');
            return $this->redirectToRoute('app_profil');
        }

        $pseudo = $request->request->get('pseudo');
        if (!$pseudo) {
            $this->addFlash('error', 'Pseudo non fourni.');
            return $this->redirectToRoute('app_profil');
        }

        $utilisateur = $entityManager->getRepository(Utilisateur::class)->findOneBy(['pseudo' => $pseudo]);

        if (!$utilisateur) {
            $this->addFlash('error', 'Utilisateur introuvable.');
            return $this->redirectToRoute('app_profil');
        }

        if ($utilisateur->getGroupe() === $groupe) {
            $this->addFlash('error', 'Cet utilisateur est déjà dans ce groupe.');
            return $this->redirectToRoute('app_profil');
        }

        $utilisateur->setGroupe($groupe);
        $entityManager->flush();

        $this->addFlash('success', "L'utilisateur $pseudo a été ajouté au groupe avec succès.");

        return $this->redirectToRoute('app_groupe_afficher', ['id' => $groupeId]);
    }
}
