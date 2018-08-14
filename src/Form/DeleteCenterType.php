<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 30/07/2018
 * Time: 09:41
 */

namespace App\Form;


use App\Center\CenterRequest;
use App\Entity\Center;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeleteCenterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)

    {
        $builder
            ->add('center_id', EntityType::class, array(
                // looks for choices from this entity
                'class' => Center::class,

                // uses the User.username property as the visible option string
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false,
                'label' => 'Nom du centre',

            ))

            ->add('submit', SubmitType::class, [

                'label' => 'Supprimer le centre'

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