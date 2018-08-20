<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 24/07/2018
 * Time: 12:37
 */

namespace App\Form;

use App\Employee\EmployeeRequest;
use App\Entity\Center;
use App\Entity\Employee;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\EmailType;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)

    {
        $this->etat = $options['etat'];

        $builder
            ->add('username', TextType::class, [

                'required'  => true,
                'label'     => 'Nom',
                'attr'      => [

                    'placeholder' => 'Nom :'

                ]

            ]);

        if ($this->etat) {
            $builder->add('password',PasswordType::class,[
                'label'=>"Mot de passe",
                'required'=>false,
            ]);
        }
        else
        {
            $builder->add('password',PasswordType::class,[
                'label'=>"Mot de passe",
                'required'=>true,
            ]);
        }



            $builder->add('email',EmailType::class,[
                'label'=>"Email",
                'required'=>true,
            ])


            ->add('center', EntityType::class, array(
                // looks for choices from this entity
                'class' => Center::class,

                // uses the User.username property as the visible option string
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false,
                'label' => 'Nom du centre',

            ));

        if ($this->etat) {
            $builder->add('submit', SubmitType::class, [

                'label' => 'Modifier ses infos'

            ]);
        }
        else
        {
            $builder->add('submit', SubmitType::class, [

                'label' => 'Créer l\'employé'

            ]);
        }

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => EmployeeRequest::class,
                'etat' => null
            ]);
    }
}