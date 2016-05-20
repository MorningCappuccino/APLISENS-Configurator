<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecialVersionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('descr')
            ->add('bodyTypes', EntityType::class, array(
                'class' => 'AppBundle\Entity\BodyType',
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true
            ))
            ->add('processConnections', EntityType::class, array(
                'class' => 'AppBundle\Entity\ProcessConnection',
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\SpecialVersion'
        ));
    }
}
