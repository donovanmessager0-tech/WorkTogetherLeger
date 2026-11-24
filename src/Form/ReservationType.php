<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Offre;
use App\Entity\Reservation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('offre', EntityType::class, [
                'class' => Offre::class,
                'choice_label' => 'nom',
            ])
->add('period', ChoiceType::class, [
                'label' => 'Périodicité',
                'choices' => [
                    'Mensuel' => 'mensuel',
                    'Annuel' => 'annuel',
],
                'expanded' => true, 
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
