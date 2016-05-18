<?php

namespace AppBundle\Form;

use AppBundle\Entity\EqMode;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BodyTypeType extends AbstractType
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
//            ->add('eqModes', EntityType::class, array(
//                'class' => 'AppBundle:EqMode',
//                'choice_label' => 'name',
//                'expanded' => true,
//                'multiple' => true
//            ))
//            ->add('eqModes')
//            ->add('specialVersions', null, array(
//                'expanded' => true,
//                'multiple' => true
//            ))
//            ->add('specialVersions')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\BodyType'
        ));
    }

//    public function getName()
//    {
//        return 'EqMode'; // this is the name of your type, you can use it instead 'entity' in your add method
//    }
}
