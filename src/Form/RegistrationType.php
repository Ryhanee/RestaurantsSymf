<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, $this->getConfiguration("Nom","Votre nom"))
            ->add('prenom', TextType::class, $this->getConfiguration("Prénom","Votre prénom"))
            ->add('tel', TextType::class, $this->getConfiguration("Telephone","Votre téléphone"))
            ->add('email', EmailType::class, $this->getConfiguration("Email", "Votre adresse mail"))
            ->add('password', PasswordType::class, $this->getConfiguration("Password", "Tapez votre mot de passe"))
            ->add('passwordConfirmation', PasswordType::class, $this->getConfiguration("Confirmation de mot de passe", "Confirmer votre mot de passe"))
            ->add('username', TextType::class, $this->getConfiguration("Slug","Votre slug"))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
