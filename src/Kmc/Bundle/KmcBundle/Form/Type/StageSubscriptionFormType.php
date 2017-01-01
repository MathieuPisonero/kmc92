<?php

namespace Kmc\Bundle\KmcBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class StageSubscriptionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$years = array();
    	for($i=1950;$i<=2014;$i++)
    	{
    	$years[]=$i;
    	}
    		$builder->add('civility', 'choice', array('required'=>false,
    				'choices' => array('0'=>'Mlle', '1'=>'Mme','2'=>'M.'),
    				'expanded'=>true,
    				'multiple'=>false,
    				'empty_value'  => false))
    						->add('lastname', 'text', array('label'=>'Nom','required'=>false))
    						->add('firstname', 'text', array('label'=>'Prénom','required'=>false))
    						->add('email', 'text', array('label'=>'e-mail','required'=>false))
    						->add('phone', 'text', array('label'=>'N° de téléphone','required'=>false))
    						->add('birthdate', 'date',array(    'label'  =>'Date de naissance',
    								'widget' => 'choice',
    								'required'=>false,
    								'format' => "dd <span>/</span> MM <span>/</span> yyyy",
    								'years'=>$years))
    						->add('responsablelastname', 'text', array('label'=>'Nom du tuteur légal','required'=>false))
    						->add('responsablefirstname', 'text', array('label'=>'Prenom du tuteur légal','required'=>false))
                			->add("next_step", 'submit',array('label'=>"Etape suivante"));
    }

    public function getName()
    {
        return 'kmc_subscription_stage_subscription';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }
}