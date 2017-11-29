<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
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
                "placeholder" => "navbar.searchForm.placeholder",
                "class" => "form-control mr-sm-2"
            ]
        ]);
    }
}
