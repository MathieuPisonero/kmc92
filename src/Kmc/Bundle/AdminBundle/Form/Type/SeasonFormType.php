<?php
// src/Acme/DemoBundle/Form/Type/FriendMessageFormType.php
namespace Kmc\Bundle\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class SeasonFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array('label'=>'Nom'))
                ->add('seasonstart', DateType::class,array(  'label'  =>'Début de la saison',
                                                    'widget' => 'choice',
                                                    'required'=>false,
                                                    'format' => "dd MM yyyy"))
                ->add('seasonend', DateType::class,array( 'label'  =>'Fin de la saison',
                                                 'widget' => 'choice',
                                                 'required'=>false,
                                                 'format' => "dd MM yyyy"))
                ->add("save", SubmitType::class,array('label'=>"Enregistrer"));
    }

    public function getName()
    {
        return 'kmc_admin_season';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        //$resolver->setDefaults(array('csrf_protection' => false));
    }
}