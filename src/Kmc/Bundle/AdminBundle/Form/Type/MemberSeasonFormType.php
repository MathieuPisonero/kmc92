<?php
// src/Acme/DemoBundle/Form/Type/FriendMessageFormType.php
namespace Kmc\Bundle\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MemberSeasonFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        	$builder->add(  'price', EntityType::class, array(
				            'required'=>false,
				            'label' => "Mode de paiement",
				            'class' => 'KmcKmcBundle:Price',
        					'required'  => true,
				            'by_reference' => true
				        ))
				        ->add(  'season', EntityType::class, array(
				        		'required'=>false,
				        		'label' => "Saison",
				        		'class' => 'KmcKmcBundle:Season',
				        		'by_reference' => true,
				    			'required'  => true,
				        		'query_builder' => function(EntityRepository $er)
				        		{
				        			return $er->createQueryBuilder('u')
				        			->where("u.seasonend > '" . date('Y/m/d 00:00:00')."'");
				        		}
				        ));
    }

    public function getName()
    {
        return 'kmc_admin_memberseason';
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
    	$resolver->setDefaults(array(
    			'data_class' => 'Kmc\Bundle\AdminBundle\Entity\MemberSeason',
    			'csrf_protection' => false
    	));
    }
}