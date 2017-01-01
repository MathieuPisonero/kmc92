<?php
// src/Acme/DemoBundle/Form/Type/FriendMessageFormType.php
namespace Kmc\Bundle\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewMemberFormType extends AbstractType
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
                ->add('job', 'text', array('label'=>'Profession','required'=>false))
                ->add('birthdate', 'date',array(    'label'  =>'Date de naissance',
                                                    'widget' => 'choice',
                                                    'required'=>true,
                                                    'format' => "dd <span>/</span> MM <span>/</span> yyyy",
                                                    'years'=>$years))
                ->add('responsablelastname', 'text', array('label'=>'Nom du tuteur légal','required'=>false))
                ->add('responsablefirstname', 'text', array('label'=>'Prenom du tuteur légal','required'=>false))
                ->add('adress', 'text',array('label'=>'Adresse','required'=>false))
                ->add('zipcode', 'text', array('label'=>'Code Postal','required'=>false))
                ->add('city', 'text',array('label'=>'Ville','required'=>false))
                ->add('practiceyear', 'choice', array( 'required'=>true,
                                                       'label'=>'Nombre d\'année de pratique',
                                                       'choices' => array('0'=>'débutant', '1'=>'1 an', '2'=>'2 ans', '3' =>'3 ans', '4' =>'4 ans', '5' =>'5 ans', '6' =>'6 ans', '7' =>'7 ans', '8' =>'8 ans', '9' =>'9 ans', '10' =>'10 ans', '11' =>'11 ans','12' =>'12 ans', ),
                                                       'preferred_choices' => array('0'),
                                                ))
                ->add('praticelevel', 'choice', array(
                    'required'=>true,
                    'choices' => array('none'=>'Aucune', 'jaune'=>'Jaune', 'orange' =>'Orange', 'verte' =>'Verte', 'bleu'=>'Bleu', 'marron'=>'Marron','noire'=>'Noire'),
                    'preferred_choices' => array('none'),
                ))
                ->add('seasons', 'collection', array ( 'type' => new MemberSeasonFormType(),'by_reference' => true, 'label'=>false));
    }

    public function getName()
    {
        return 'kmc_new_member';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('csrf_protection' => false));
    }
}