<?php

namespace App\Form;

use App\Entity\ConfigurationPayfip;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PayFipCreanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('numcli', TextType::class,[
                'attr' => [
                    'maxlength' => 6,
                ]
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'titre' => 'titre',
                    'role' => 'role' ,
                ]
            ])
            //TODO en construction
            ->add('file', FileType::class, [
                'label' => 'Choisir un fichier CSV',
                'mapped' => false,
                ])        
            ->add('submit', SubmitType::class, ['label' => 'Valider'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => ['enctype' => 'multipart/form-data'],
            'data_class' => ConfigurationPayfip::class,
            ]);
    }
}
