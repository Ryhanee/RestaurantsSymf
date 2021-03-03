<?php

namespace App\Form;

use App\Entity\Restaurant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class RestaurantType extends ApplicationType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', TextType::class, $this->getConfiguration("Libelle","Libelle"))
            ->add('specialite', TextType::class, $this->getConfiguration("Spécialité","spécialité"))
            ->add('tel', TextType::class, $this->getConfiguration("Téléphone","téléphone"))
            ->add('email', TextType::class, $this->getConfiguration("Email","email"))
            ->add('image', FileType::class, [
                'label' => 'Image',
                'data_class' => null
            ])
            ->add('adresse_resto',EntityType::class, array(
                'class' => 'App\Entity\Emplacement',
                'choice_label'=>'adresse',
                'expanded'=>false,
                'multiple'=>false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Restaurant::class,
        ]);
    }
}
