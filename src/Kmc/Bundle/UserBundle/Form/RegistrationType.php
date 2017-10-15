<?php
            		
namespace Kmc\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
            		
class RegistrationType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder->add('civility', ChoiceType::class, array('required'=>true,
    			'choices' => array('Mlle'=>0, 'Mme'=>1, 'M.'=>2),
    			'expanded'=>true,
    			'multiple'=>false))
    			->add('lastname', TextType::class, array('label'=>'Nom','required'=>true))
    			->add('firstname', TextType::class, array('label'=>'Prénom','required'=>true))
    			->add('phone', TextType::class, array('label'=>'Téléphone','required'=>true));
     }
            			
     public function getParent()
     {
     	return 'FOS\UserBundle\Form\Type\RegistrationFormType';

     }
     
     public function getBlockPrefix()
     {
     	return 'kmc_user_registration';
     }
     
     // For Symfony 2.x
     public function getName()
     {
     	return $this->getBlockPrefix();
     }
}
