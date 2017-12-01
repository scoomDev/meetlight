<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SearchType;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('search', SearchType::class, [
            'label' => false,
            'translation_domain' => 'AppTranslate',
            'attr' => [
                "placeholder" => "searchBar.searchForm.placeholder",
                "class" => "form-control mr-sm-2"
            ]
        ])
        ->add('skill', EntityType::class, [
                'class' => 'AppBundle\Entity\Skill',
                'translation_domain' => 'AppTranslate',
                'label' => false,
        ])
        ->add('distance', ChoiceType::class, [
                'choices' => [
                        'searchBar.distance.choices.20' => 20,
                        'searchBar.distance.choices.30' => 30,
                        'searchBar.distance.choices.50' => 50,
                        'searchBar.distance.choices.100' => 100,
                        'searchBar.distance.choices.200' => 200,
                ],
            'label' => 'searchBar.distance.label',
            'translation_domain' => 'AppTranslate'
        ])
        ->add('submit', SubmitType::class, [
                'label' => 'searchBar.btn',
                'translation_domain' => 'AppTranslate',
                'attr' => [
                        'class' => 'btn btn-primary w-100'
                ]
        ])
        ;
    }
}
