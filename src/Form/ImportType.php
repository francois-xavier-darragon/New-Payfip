<?php

namespace App\Form;

// use App\Entity\ConfigurationPayfip;
use App\Entity\Import;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

class ImportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('option_select_ref',ChoiceType::class, [
                'label' => 'Référence PAYFIP ',
                'placeholder' => 'Selectionner une valeur',
                'choices' => $options['headers'],

            ])

            ->add('option_select_montant', ChoiceType::class, [
                'label' => 'Montant ',
                'placeholder' => 'Selectionner une valeur',
                'choices' => $options['headers'],
            ])
            ->add('submit', SubmitType::class, ['label' => 'Valider'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // 'data_class' => ConfigurationPayfip::class,
            'data_class' => Import::class,
            'headers' => null,
        ]);
    }
}
