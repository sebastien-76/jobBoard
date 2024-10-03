<?php

namespace App\Form;

use App\Entity\Tag;
use App\Entity\Offre;
use App\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => "Nom de l'offre",
                'attr' => [
                    'class' => "border-2 border-blue-500 rounded-lg p-2 m-2 ",
                ],
            ])
            ->add('description', TextType::class, [
                'label' => "Description de l'offre",
                'attr' => [
                    'class' => "border-2 border-blue-500 rounded-lg p-2 m-2 content-center",
                ],
            ])
            ->add('salaire', TextType::class, [
                'label' => "Salaire de l'offre",
                'attr' => [
                    'class' => "border-2 border-blue-500 rounded-lg p-2 m-2 ",
                ],
            ])
            ->add('service', EntityType::class, [
                'class' => Service::class,
                'choice_label' => 'nom',
                'label' => "Service de l'offre",
                'attr' => [
                    'class' => "border-2 border-blue-500 rounded-lg p-2 m-2 ",
                ],
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'nom',
                'multiple' => true, 
                'label' => "Tags de l'offre",
                'attr' => [
                    'class' => "border-2 border-blue-500 rounded-lg p-2 m-2",
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Créer l'offre",
                'attr' => [
                    'class' => "border-2 border-blue-500 rounded-lg p-2 m-4 bg-blue-500 text-white",
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}
