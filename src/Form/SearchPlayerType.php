<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 31/07/2018
 * Time: 16:59
 */

namespace App\Form;


use App\Entity\Center;
use App\Entity\Customer;
use App\Repository\CustomerRepository;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\EmailType;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class SearchPlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)

    {

        $builder

            ->add('number', TextType::class, [

                'required'  => true,
                'label'     => 'Numéro',
                'attr'      => [

                    'placeholder' => 'Numéro :'

                ]
            ])

            ->add('submit', SubmitType::class, [

                'label' => 'Chercher'

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