<?php

namespace App\Form;

use App\Center\CenterRequest;
use App\Entity\Center;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\EmailType;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

class AddCenterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)

    {
        $this->etat = $options['etat'];

        if ($this->etat)
        {
            $builder->add('center', EntityType::class, array(
            // looks for choices from this entity
            'class' => Center::class,

            // uses the User.username property as the visible option string
            'choice_label' => 'name',
            'expanded' => false,
            'multiple' => false,
            'label' => 'Nom du centre à modifier'

        ));
        }

        $builder
            ->add('name', TextType::class, [

                'required'  => true,
                'label'     => 'Name',
                'attr'      => [

                    'placeholder' => 'Name :'

                ]
            ])

            ->add('city', TextType::class, [

                'required'  => true,
                'label'     => 'Ville',
                'attr'      => [

                    'placeholder' => 'Ville :'

                ]
            ])

            ->add('code', TextType::class, [

                'required'  => true,
                'label'     => 'Code',
                'attr'      => [

                    'placeholder' => 'Code :'

                ]
            ]);

            if ($this->etat)
            {
                $builder->add('submit', SubmitType::class, [

                    'label' => 'Modifier le centre'

                ]);
            }
            else
            {
                $builder->add('submit', SubmitType::class, [

                    'label' => 'Créer le centre'

                ]);
            }


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => CenterRequest::class,
                'etat' => null
            ]);
    }
}