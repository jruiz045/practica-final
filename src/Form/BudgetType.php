<?php

namespace App\Form;

use App\Entity\Budget;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BudgetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price')
            ->add('candidateName')
            ->add('candidateEmail')
            ->add('candidatePhone')
            ->add('appId')
            ->add('featureId')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Budget::class,
        ]);
    }
}
