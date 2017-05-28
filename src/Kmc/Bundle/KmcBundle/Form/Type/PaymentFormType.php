<?php

namespace Kmc\Bundle\KmcBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
//use Kmc\Bundle\KmcBundle\Form\Type\MemberInformationFormType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PaymentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(  'payment', EntityType::class, array(
                'required'=>false,
                'label' => "Mode de paiement",
                'class' => 'KmcKmcBundle:Payment',
                'by_reference' => true,
                'placeholder' => 'Choissisez un mode de paiment',
                'choice_label' => 'name',
                ));
        $builder->add(  'price', EntityType::class, array(
            'required'=>false,
            'label' => "Mode de paiement",
            'class' => 'KmcKmcBundle:Price',
            'by_reference' => true,
            'placeholder' => 'Selectionner votre tarif',
            'query_builder' => function(EntityRepository $er)
                               {
                                    return $er->createQueryBuilder('u')
                                              ->where('u.active = 1');
                               }
        ));
        $builder->add("next_step", SubmitType::class,array('label'=>"Etape suivante"));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('name' => "payment_form_payment",
            'data_class' => 'Kmc\Bundle\KmcBundle\Entity\Subscription',
        ));
    }
}