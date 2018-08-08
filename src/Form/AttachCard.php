<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 30/07/2018
 * Time: 12:08
 */

namespace App\Form;
use App\Entity\Center;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\EmailType;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

class AttachCard extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)

    {
        $builder
            ->add('card_number', TextType::class, [

                'required'  => true,
                'label'     => 'Numéro de carte :',
                'attr'      => [

                    'placeholder' => 'Card Number :'

                ]

            ])
            ->add('submit', SubmitType::class, [

                'label' => 'Rattacher la carte'

            ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => null
            ]);
    }


}