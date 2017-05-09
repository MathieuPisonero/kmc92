<?php
// src/Acme/DemoBundle/Form/Type/FriendMessageFormType.php
namespace Kmc\Bundle\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PriceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array('label'=>'Nom'))
        		->add('price', TextType::class, array('label'=>'Tarif'))
                ->add("save", SubmitType::class,array('label'=>"Enregistrer"));
    }

    public function getName()
    {
        return 'kmc_admin_price';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        //$resolver->setDefaults(array('csrf_protection' => false));
    }
}