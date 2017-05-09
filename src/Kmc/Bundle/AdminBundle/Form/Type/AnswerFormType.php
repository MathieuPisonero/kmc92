<?php
// src/Acme/DemoBundle/Form/Type/FriendMessageFormType.php
namespace Kmc\Bundle\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class AnswerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('text', TextType::class, array('label'=>'Nom'))
        		->add('custom', CheckboxType::class, array('label'=>'Réponse personalisé','required'=>false));
    }

    public function getName()
    {
        return 'kmc_admin_answer';
    }

    public function configureOptions(OptionsResolver$resolver)
    {
        $resolver->setDefaults(array('csrf_protection' => false));
    }
}