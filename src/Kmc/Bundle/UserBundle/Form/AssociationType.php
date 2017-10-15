<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kmc\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Kmc\Bundle\UserBundle\Entity\Association;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class AssociationType extends AbstractType
{

	private $user;
	
	public function __construct( TokenStorage $security )
	{
		$this->user = $security->getToken()->getUser();
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$user= $this->user;
		$builder->add('name', TextType::class, array('label'=>'Nom','required'=>true))
				->add('adress1', TextType::class, array('label'=>'Adresse','required'=>false))
				->add('adress2', TextType::class, array('label'=>'complement d\'adresse','required'=>false))
				->add('zipcode', TextType::class, array('label'=>'Code postal','required'=>false))
				->add('city', TextType::class, array('label'=>'Ville','required'=>false))
				->add('phone', TextType::class, array('label'=>'Téléphone','required'=>false))
				->add('logo', FileType::class, array('data_class'=>null,'label'=>'Logo du club','required'=>false))
				->add(  'parentclub', EntityType::class, array(
						'required'=>false,
						'label' => "Club affilié",
						'class' => 'KmcUserBundle:Association',
						'by_reference' => true,
						'query_builder' => function(EntityRepository $er) use ($user)
						{
							return $er->createQueryBuilder('u')
							->where("u.user = " . $this->user->getId() . " AND u.parentclub IS NULL");
						},
						'choice_label' => 'name'
				));
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => "Kmc\Bundle\UserBundle\Entity\Association",
				'allow_extra_fields' => true,
				'csrf_protection' => false
		));
	}
	
	/*
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return null;
    }

}
