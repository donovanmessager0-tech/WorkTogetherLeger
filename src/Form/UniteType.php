<?php

namespace App\Form;

use App\Entity\Baie;
use App\Entity\Unite;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UniteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('status', EntityType::class, [
                'class' => Baie::class,
                'choice_label' => 'id',
            ])
            ->add('Status', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'Name',
                'required' => false,
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Unite::class,
        ]);
    }
}
