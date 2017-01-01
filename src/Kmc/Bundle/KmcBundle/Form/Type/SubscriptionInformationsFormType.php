<?php

namespace Kmc\Bundle\KmcBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


//use Kmc\Bundle\KmcBundle\Form\Type\MemberInformationFormType;

class SubscriptionInformationsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('informations', CollectionType::class, array ( 'entry_type' => SubscriptionInformationFormType::class,'by_reference' => true, 'label'=>false));
        $builder->add("return", SubmitType::class, array("label"=>'Etape précedente'));
        $builder->add("next_step", SubmitType::class, array("label"=>'Etape suivante'));
    }

    public function getName()
    {
        return 'kmc_subscription_informations';
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kmc\Bundle\KmcBundle\Entity\Subscription',
            'csrf_protection' => false,
        ));
    }
}