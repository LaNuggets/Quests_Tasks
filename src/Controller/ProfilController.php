<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\ProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var Utilisateur $utilisateur */
        $utilisateur = $this->getUser();
        $groupe = $utilisateur->getGroupe();
        $habitudes = $utilisateur->getHabitudes();


        $form = $this->createForm(ProfilType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form->get('profilePicture')->getData();

            if ($photoFile) {
                if ($photoFile->isValid()) {
                    $nomFichier = uniqid() . '.' . $photoFile->guessExtension();
                    $photoFile->move(
                        $this->getParameter('photo_directory'),
                        $nomFichier
                    );
                    $utilisateur->setProfilePicture($nomFichier);
                } else {
                    $this->addFlash('error', 'Erreur lors de l’upload de l’image.');
                }
            }

            $entityManager->persist($utilisateur);
            $entityManager->flush();

            $this->addFlash('success', 'Profil mis à jour avec succès !');

            return $this->redirectToRoute('app_profil');
        }

        return $this->render('twig/users.html.twig', [
            'user' => $utilisateur,
            'form' => $form->createView(),
            'groupe' => $groupe,
            'habitudes' => $habitudes,
        ]);        
    }
    
    #[Route('/profil/update', name: 'app_profil_update')]
    public function update(Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var Utilisateur $utilisateur */
        $utilisateur = $this->getUser();
        $groupe = $utilisateur->getGroupe();
        $habitudes = $utilisateur->getHabitudes();


        $form = $this->createForm(ProfilType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form->get('profilePicture')->getData();

            if ($photoFile) {
                if ($photoFile->isValid()) {
                    $nomFichier = uniqid() . '.' . $photoFile->guessExtension();
                    $photoFile->move(
                        $this->getParameter('photo_directory'),
                        $nomFichier
                    );
                    $utilisateur->setProfilePicture($nomFichier);
                } else {
                    $this->addFlash('error', 'Erreur lors de l’upload de l’image.');
                }
            }

            $entityManager->persist($utilisateur);
            $entityManager->flush();

            return $this->redirectToRoute('app_profil');
        }
        return $this->render('profil/index.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
            'groupe' => $groupe,
            'habitudes' => $habitudes,
        ]);        
    }
}
