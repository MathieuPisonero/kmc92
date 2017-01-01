<?php
// src/Acme/DemoBundle/Form/Type/FriendMessageFormType.php
namespace Kmc\Bundle\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class StageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array('label'=>'Intitulé'))
        		->add('description', 'textarea', array('label'=>'Déscription'))
        		->add('dateStart', 'date',array(    'label'  =>'Date de début',
                                                    'widget' => 'choice',
                                                    'required'=>true,
                                                    'format' => "dd <span>/</span> MM <span>/</span> yyyy"))
				->add('timeStart', 'text', array('label'=>'Heure de début'))
				->add('dateEnd', 'date',array(  'label'  =>'Date de fin',
												'widget' => 'choice',
												'required'=>true,
												'format' => "dd <span>/</span> MM <span>/</span> yyyy"))
				->add('timeEnd', 'text', array('label'=>'Heure de début'))
				->add('arrivalTime', 'text', array('label'=>'Heure d\'arrivé conseillé'))
				->add('place', 'text', array('label'=>'Lieux du stage'))
				->add('adress', 'text', array('label'=>'Adresse'))
				->add('price', 'text', array('label'=>'Prix du stage'))
				->add('duration', 'text', array('label'=>'Durée du stage'));
    }

    public function getName()
    {
        return 'kmc_admin_stage_edit';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('csrf_protection' => false));
    }
}