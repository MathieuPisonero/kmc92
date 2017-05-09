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
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class InformationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('text',TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    	$resolver->setDefaults(array('csrf_protection' => false));
    }

    public function getName()
    {
        return 'information';
    }
    
}