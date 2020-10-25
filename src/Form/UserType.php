<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\CallbackTransformer;

class UserType extends AbstractType 
{

    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder
                ->add('email')
                ->add('Roles', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => false,
                    'choices' => [
                        'Admin' => 'ROLE_ADMIN',
                        'Sales' => 'ROLE_SALES',
                        'Chief Project' => 'ROLE_CHIEF_PROJECT',
                        'Technician' => 'ROLE_TECHNICIAN',
                        'Client' => 'ROLE_CLIENT',
                    ],
                ])
                ->add('password')
        ;
        
        $builder->get('Roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    return count($rolesArray)? $rolesArray[0]: null;
            },
            function ($rolesString) {
                return [$rolesString];
            }
        ));
    }

    public function configureOptions(OptionsResolver $resolver) 
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

}
