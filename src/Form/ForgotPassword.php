<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 31/07/2018
 * Time: 11:13
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForgotPassword extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [

                'label' => "Nom d'utilisateur",

                'attr' => ['placeholder' => "Nom d'utilisateur :"]

            ])
            ->add('submit', SubmitType::class, [

                'label' => 'Valider'

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