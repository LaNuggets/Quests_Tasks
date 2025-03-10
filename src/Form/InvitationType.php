<?php

namespace App\Form;

use App\Entity\Groupe;
use App\Entity\Invitation;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class InvitationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('recepetur', EntityType::class, [
                'label' => 'Rechercher un utilisateur à ajouter',
                'class' => Utilisateur::class,
                'choice_label' => 'pseudo',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Invitation::class,
        ]);
    }
}
