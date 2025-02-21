<?php

namespace App\Controller;

use App\Entity\Invitation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


final class InvitationController extends AbstractController
{

        #[Route('/delete_invit/{id}', name: 'app_delete_invit', methods: ['POST'])]
    public function delete_invit(int $id, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $invitation = $entityManager->getRepository(Invitation::class)->find($id);

        $entityManager->remove($invitation);
        $entityManager->flush();

        return $this->redirectToRoute('app_profil');
        }

            #[Route('/accept_invit/{id}', name: 'app_accept_invit', methods: ['POST'])]
    public function accept_invit(int $id, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $invitation = $entityManager->getRepository(Invitation::class)->find($id);
        $groupe = $invitation->getGroupe();
        $user->setGroupe($groupe);

        $groupe->addMembreId($invitation->getRecepetur()->getId());
        
        $entityManager->flush();

        return $this->redirectToRoute('app_profil');
        }
}
