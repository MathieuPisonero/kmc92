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

use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProfileType extends AbstractType
{

	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('civility', ChoiceType::class, array('required'=>true,
				'choices' => array('Mlle'=>0, 'Mme'=>1, 'M.'=>2),
				'expanded'=>true,
				'multiple'=>false))
				->add('lastname', TextType::class, array('label'=>'Nom','required'=>true))
				->add('firstname', TextType::class, array('label'=>'Prénom','required'=>true))
				->add('phone', TextType::class, array('label'=>'Téléphone','required'=>true))
				->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'))
				->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'));
	}

    /*public function getParent()
    {
    	return 'FOS\UserBundle\Form\Type\ProfileFormType';
    	
    }*/
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'Kmc\Bundle\UserBundle\Entity\User',
				'csrf_token_id' => 'profile',
				// BC for SF < 2.8
				'intention' => 'profile',
		));
	}
    // BC for SF < 3.0
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'kmc_user_profile';
    }

    /**
     * Builds the embedded form representing the user.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    protected function buildUserForm(FormBuilderInterface $builder, array $options)
    {

    }
}
