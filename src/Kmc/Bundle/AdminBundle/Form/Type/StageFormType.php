<?php
// src/Acme/DemoBundle/Form/Type/FriendMessageFormType.php
namespace Kmc\Bundle\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class StageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array('label'=>'Intitulé'))
        ->add('description', TextareaType::class, array('label'=>'Déscription'))
        		->add('dateStart', datetype::class,array(    'label'  =>'Date de début',
                                                    'widget' => 'choice',
                                                    'required'=>true,
                                                    'format' => "dd MM yyyy"))
				->add('timeStart', TextType::class, array('label'=>'Heure de début'))
				->add('dateEnd', DateType::class,array(  'label'  =>'Date de fin',
												'widget' => 'choice',
												'required'=>true,
												'format' => "dd MM yyyy"))
				->add('timeEnd', TextareaType::class, array('label'=>'Heure de début'))
				->add('arrivalTime', TextType::class, array('label'=>'Heure d\'arrivé conseillé'))
				->add('place', TextType::class, array('label'=>'Lieux du stage'))
				->add('adress', TextType::class, array('label'=>'Adresse'))
				->add('price', TextType::class, array('label'=>'Prix du stage'))
				->add('duration', TextType::class, array('label'=>'Durée du stage'))
				->add('image', FileType::class, array('label' => 'Image (JPEG file)','data_class' => null));
				
    }

    public function getName()
    {
        return 'kmc_admin_stage_edit';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    	$resolver->setDefaults(array(
    			'csrf_protection' => false,
    			'data_class' => 'Kmc\Bundle\AdminBundle\Entity\Stage'
    	));
    }
}