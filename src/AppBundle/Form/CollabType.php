<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollabType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startedAt', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                    'aria-describedby' => 'datepickerAddon'
                ]
            ])
            ->add('finishedAt', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                    'aria-describedby' => 'datepickerAddon'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'create-collab.save',
                'translation_domain' => 'AppTranslate',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Collab'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_collab';
    }


}
