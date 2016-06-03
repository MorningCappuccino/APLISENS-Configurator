<?php

namespace AppBundle\Form;


use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EqModeType extends AbstractType
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
            ->add('imageFile', VichImageType::class, array(
                'required'      => false,
                'allow_delete'  => true, // not mandatory, default is true
                'download_link' => false,// not mandatory, default is true
            ))
            ->add('eqType')
            ->add('accuracyClasses', null, array( //works: CollectionType
                'expanded' => true,
                'choice_label' => 'getDisplayName'
            ))
            ->add('specialVersions', EntityType::class, array(
                'class' => 'AppBundle:SpecialVersion',
//                'choice_label' => 'id', //if no __toString method
                'expanded' => true,
                'multiple' => true,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('s')
//                        ->select('s.name')
                        ->orderBy('s.name', 'ASC');
                }

            ))
            ->add('measurementRanges', EntityType::class, array(
                'class' => 'AppBundle:MeasurementRange',
//                'choice_label' => function($measurementRanges){
//                    return $measurementRanges->getDisplayName();
//                },
                'choice_label' => 'DisplayName',
                'expanded' => true,
                'multiple' => true,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('m')
                        ->orderBy('m.unit')
                        ->addOrderBy('m.theRange');
                }
            ))
            ->add('bodyTypes', EntityType::class, array(
                'class' => 'AppBundle\Entity\BodyType',
                'choice_label' => 'getName',
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
            'data_class' => 'AppBundle\Entity\EqMode'
        ));
    }
}
