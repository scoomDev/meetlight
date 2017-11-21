<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                    'label' => 'form.firstname',
                    'translation_domain' => 'FOSUserBundle'
            ])
            ->add('lastName', TextType::class, [
                    'label' => 'form.lastname',
                    'translation_domain' => 'FOSUserBundle'
            ])
            ->add('skill', EntityType::class, [
                    'class' => 'AppBundle\Entity\Skill',
                    'label' => 'form.skill',
                    'translation_domain' => 'FOSUserBundle'
            ])
            ->add('street_number', HiddenType::class)
            ->add('route', HiddenType::class)
            ->add('locality', HiddenType::class)
            ->add('country', HiddenType::class)
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }


    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }


    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
