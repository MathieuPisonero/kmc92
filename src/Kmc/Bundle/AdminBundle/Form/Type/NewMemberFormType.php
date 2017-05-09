<?php
// src/Acme/DemoBundle/Form/Type/FriendMessageFormType.php
namespace Kmc\Bundle\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class NewMemberFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $years = array();
        for($i=1950;$i<=2014;$i++)
        {
            $years[]=$i;
        }
        $builder->add('civility', ChoiceType::class, array('required'=>true,
                                                 'choices' => array('Mlle'=>0, 'Mme'=>1,'M.'=>2),
                                                 'expanded'=>true,
                                                 'multiple'=>false))
        		->add('lastname', TextType::class, array('label'=>'Nom','required'=>false))
                ->add('firstname', TextType::class, array('label'=>'Prénom','required'=>false))
                ->add('email', TextType::class, array('label'=>'e-mail','required'=>false))
                ->add('phone', TextType::class, array('label'=>'N° de téléphone','required'=>false))
                ->add('job', TextType::class, array('label'=>'Profession','required'=>false))
                ->add('birthdate', DateType::class,array(    'label'  =>'Date de naissance',
                                                    'widget' => 'choice',
                                                    'required'=>true,
                                                    'format' => "dd / MM / yyyy",
                                                    'years'=>$years))
                ->add('responsablelastname', TextType::class, array('label'=>'Nom du tuteur légal','required'=>false))
                ->add('responsablefirstname', TextType::class, array('label'=>'Prenom du tuteur légal','required'=>false))
                ->add('adress', TextType::class,array('label'=>'Adresse','required'=>false))
                ->add('zipcode', TextType::class, array('label'=>'Code Postal','required'=>false))
                ->add('city', TextType::class,array('label'=>'Ville','required'=>false))
                ->add('practiceyear', ChoiceType::class, array( 'required'=>true,
                                                       'label'=>'Nombre d\'année de pratique',
                		'choices' => array('débutant'=>'0', '1 an'=>'1', '2 ans'=>'2', '3 ans'=>'3', '4 ans'=>'4', '5 ans'=>'5', '6 ans'=>'6', '7 ans'=>'7', '8 ans'=>'8', '9 ans'=>'9', '10 ans'=>'10', '11 ans'=>'11', '12 ans'=>'12'),
                                                       'preferred_choices' => array('0'),
                                                ))
                ->add('praticelevel', ChoiceType::class, array(
                    'required'=>true,
                    'choices' => array('none'=>'Aucune', 'jaune'=>'Jaune', 'orange' =>'Orange', 'verte' =>'Verte', 'bleu'=>'Bleu', 'marron'=>'Marron','noire'=>'Noire'),
                    'preferred_choices' => array('none'),
                ))
                //->add('seasons', MemberSeasonFormType::class);
                ->add('seasons', CollectionType::class, array ( 'entry_type'=>MemberSeasonFormType::class, 'by_reference'=>false, 'label'=>false));
    }

    public function getName()
    {
        return 'kmc_new_member';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('csrf_protection' => false));
    }
}