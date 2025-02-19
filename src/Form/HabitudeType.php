<?php

namespace App\Form;

use App\Entity\Habitude;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HabitudeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('texte', TextType::class, [
                'label' => 'Texte de l\'habitude',
                'attr' => ['class' => 'form-control']
            ])
            ->add('difficulte', ChoiceType::class, [
                'label' => 'Difficulté',
                'choices' => [
                    'Facile' => 'Facile',
                    'Moyenne' => 'Moyenne',
                    'Difficile' => 'Difficile'
                ],
                'attr' => ['class' => 'form-control']
            ])
            ->add('periodicite', ChoiceType::class, [
                'label' => 'Périodicité',
                'choices' => [
                    'Quotidienne' => 'Quotidienne',
                    'Hebdomadaire' => 'Hebdomadaire',
                    'Mensuelle' => 'Mensuelle'
                ],
                'attr' => ['class' => 'form-control']
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Ajouter Habitude',
                'attr' => ['class' => 'btn btn-primary mt-3']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Habitude::class,
        ]);
    }
}
