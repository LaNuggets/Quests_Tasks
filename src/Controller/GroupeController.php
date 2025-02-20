<?php

namespace App\Controller;

use App\Entity\Groupe;
use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Request;

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
}
