<?php
// src/Acme/DemoBundle/Form/Type/FriendMessageFormType.php
namespace Kmc\Bundle\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SeasonFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array('label'=>'Nom'))
                ->add('seasonstart', 'date',array(  'label'  =>'Début de la saison',
                                                    'widget' => 'choice',
                                                    'required'=>false,
                                                    'format' => "dd MM yyyy"))
                ->add('seasonend', 'date',array( 'label'  =>'Fin de la saison',
                                                 'widget' => 'choice',
                                                 'required'=>false,
                                                 'format' => "dd MM yyyy"))
                ->add("save", 'submit',array('label'=>"Enregistrer"));
    }

    public function getName()
    {
        return 'kmc_admin_season';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('csrf_protection' => false));
    }
}