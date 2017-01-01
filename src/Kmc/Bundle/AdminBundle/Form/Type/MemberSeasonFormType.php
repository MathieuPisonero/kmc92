<?php
// src/Acme/DemoBundle/Form/Type/FriendMessageFormType.php
namespace Kmc\Bundle\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class MemberSeasonFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        	$builder->add(  'price', 'entity', array(
				            'required'=>false,
				            'label' => "Mode de paiement",
				            'class' => 'KmcKmcBundle:Price',
        					'required'  => true,
				            'by_reference' => true
				        ))
				    ->add(  'season', 'entity', array(
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

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('csrf_protection' => false,
        						'data_class' => 'Kmc\Bundle\AdminBundle\Entity\MemberSeason'));
    }
}