<?php
/**
 * Created by PhpStorm.
 * User: pisonerom
 * Date: 01/10/2014
 * Time: 23:48
 */
namespace Kmc\Bundle\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InformationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('text');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
        	'csrf_protection' => false,
            'data_class' => 'Kmc\Bundle\KmcBundle\Entity\InformationQuestion',
        ));
    }

    public function getName()
    {
        return 'information';
    }
}