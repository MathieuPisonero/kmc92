<?php

namespace Kmc\Bundle\KmcBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class SubscriptionInformationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event)
        {
            $data = $event->getData();
            $form = $event->getForm();
            $id = $data->getQuestion()->getId();

            $form->add('answer', EntityType::class, array(
            'required'=>false,
            'label' => $data->getQuestion()->getText(),
            'class' => 'KmcKmcBundle:InformationAnswer',
            'by_reference' => true,
            'placeholder' => 'Choissisez une Réponse',
            'choice_label' => 'text',
            'query_builder' => function(EntityRepository $er) use ($id) {
                    return $er->createQueryBuilder('u')
                        ->where('u.informationQuestion = :id AND u.active = 1')
                        ->setParameter('id',$id);
                }));
            $form->add('custom', TextType::class,array('required'=>false));
        });

    }

    public function getName()
    {
        return 'kmc_subscription_information';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kmc\Bundle\KmcBundle\Entity\InformationSubscription',
        	'csrf_protection' => true,
        	'csrf_field_name' => '_token',
        	// a unique key to help generate the secret token
        	'csrf_token_id'   => 'task_item',
        ));
    }
}