<?php

namespace Kmc\Bundle\KmcBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class StageSubscriptionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$years = array();
    	for($i=1950;$i<=2014;$i++)
    	{
    	$years[]=$i;
    	}
    		$builder->add('civility', ChoiceType::class, array('required'=>true,
    				'choices' => array('Mlle'=>'0', 'Mme'=>'1','M.'=>'2'),
    				'expanded'=>true,
    				'multiple'=>false))
    						->add('lastname', TextType::class, array('label'=>'Nom','required'=>false))
    						->add('firstname', TextType::class, array('label'=>'Prénom','required'=>false))
    						->add('email', TextType::class, array('label'=>'e-mail','required'=>false))
    						->add('phone', TextType::class, array('label'=>'N° de téléphone','required'=>false))
    						->add('birthdate', DateType::class,array(    'label'  =>'Date de naissance',
    								'widget' => 'choice',
    								'required'=>false,
    								'format' => "dd MM yyyy",
    								'years'=>$years))
    								->add('responsablelastname', TextType::class, array('label'=>'Nom du tuteur légal','required'=>false))
    								->add('responsablefirstname', TextType::class, array('label'=>'Prenom du tuteur légal','required'=>false))
    								->add("next_step", SubmitType::class,array('label'=>"Etape suivante"));
    }

    public function getName()
    {
        return 'kmc_subscription_stage_subscription';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    	$resolver->setDefaults(array(
    			'csrf_protection' => false
    	));
    }
}