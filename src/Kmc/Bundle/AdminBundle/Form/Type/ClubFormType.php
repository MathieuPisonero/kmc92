<?php
// src/Acme/DemoBundle/Form/Type/FriendMessageFormType.php
namespace Kmc\Bundle\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ClubFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array('label'=>'Nom du club'))
                //->add('citys', 'collection',array('type' => new CityFormType()))
                ->add("save", SubmitType::class,array('label'=>"Enregistrer"));
    }

    public function getName()
    {
        return 'kmc_admin_club';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    	$resolver->setDefaults(array(
    			'csrf_protection' => false
    	));
    }
}