<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Outing;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;

class OutingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, ["attr"=> ["class"=>"input is-rounded is-danger"]])
            ->add('startDateTime', DateTimeType::class, ["attr"=> ["class"=>"input is-rounded is-danger"]])
            ->add('duration', TextType::class, ["attr"=> ["class"=>"input is-rounded is-danger"]])
            ->add('deadlineRegistration', DateTimeType::class, ["attr"=> ["class"=>"input is-rounded is-danger"]])
            ->add('registrationMaxNb', TextType::class, ["attr"=> ["class"=>"input is-rounded is-danger"]])
            ->add('campus', EntityType::class, ['class'=>Campus::class, 'choice_label'=>'name','multiple'=>false,"placeholder"=>"Veuillez selectionner un campus"
                , "attr"=> ["class"=>"input is-rounded is-danger"]])
            ->add('outingInfo', TextType::class, ["attr"=> ["class"=>"input is-rounded is-danger"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Outing::class,
        ]);
    }
}
