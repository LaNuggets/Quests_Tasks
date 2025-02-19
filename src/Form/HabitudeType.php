<?php

namespace App\Form;

use App\Entity\Habitude;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HabitudeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('texte', TextType::class, [
                'label' => 'Description de l\'habitude',
            ])
            ->add('difficulte', ChoiceType::class, [
                'choices' => [
                    'Très Facile (1 point)' => 'très facile',
                    'Facile (2 points)' => 'facile',
                    'Moyen (5 points)' => 'moyen',
                    'Difficile (10 points)' => 'difficile',
                ],
                'label' => 'Difficulté',
            ])
            ->add('couleur', ColorType::class, [
                'label' => 'Couleur',
            ])
            ->add('periodicite', ChoiceType::class, [
                'choices' => [
                    'Quotidienne' => 'quotidienne',
                    'Hebdomadaire' => 'hebdomadaire',
                ],
                'label' => 'Périodicité',
            ])
            ->add('cible', ChoiceType::class, [
                'choices' => [
                    'Individuel' => 'individuel',
                    'Groupe' => 'groupe',
                ],
                'label' => 'Cible',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Habitude::class,
        ]);
    }
}
