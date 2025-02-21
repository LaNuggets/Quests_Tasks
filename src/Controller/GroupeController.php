<?php

namespace App\Controller;


use DateTime;
use App\Entity\Groupe;
use App\Entity\Utilisateur;
use App\Entity\Invitation;
use App\Form\InvitationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class GroupeController extends AbstractController {
    
    #[Route('/groupe/{id}', name:'app_groupe')]
    public function Groupe(Request $request, EntityManagerInterface $entityManager, int $id){
        $invit = new Invitation();
        $invitForm = $this->createForm(InvitationType::class, $invit);
        $invitForm->handleRequest($request);
        
        $user = $this->getUser();

        $groupe = $entityManager->getRepository(Groupe::class)->find($id);
        $membres = $groupe->getMembresId();
        $membresStat = [];

        $userRepository = $entityManager->getRepository(Utilisateur::class);

        foreach ($membres as $membreId) {
            $membre = $userRepository->find($membreId);
            if ($membre) {
                $membresStat[] = $membre;
            }
        }
        
        if($invitForm->isSubmitted()){
            $invit->setStatut('En Attente');
            $invit->setDateEnvoi(new DateTime('now'));
            $invit->setEmetteur($user);
            $invit->setGroupe($user->getGroupe());

            $entityManager->persist($invit);
            $entityManager->flush();
        }
        
        return $this->render('twig/group.html.twig', ['invitForm' => $invitForm->createView(), 'groupe' => $groupe, 'membres' => $membresStat]);
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

    #[Route('/groupe_connexion/', name:'app_groupe_connexion')]
     public function findGroup(Request $request, EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();
        
        $invitations = $entityManager->getRepository(Invitation::class)->findBy([
            'recepetur' => $user
        ]);

        $Tgroup = [];

    foreach ($invitations as $invitation) {
        $groupe = $invitation->getGroupe();
        
        if ($groupe && !in_array($groupe, $Tgroup, true)) {
            $Tgroup[] = $groupe;
        }
    }

        return $this->render('twig/groupconnexion.html.twig', ['invitations' =>$invitations, 'groupe' => $Tgroup]);
    }
}
