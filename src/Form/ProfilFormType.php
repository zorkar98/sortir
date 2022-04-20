<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProfilFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username',TextType::class, [
                "attr"=> [
                    "class"=>
                        "input is-rounded is-danger",
                            "pattern"=>"^[a-zA-Z0-9]([._-](?![._-])|[a-zA-Z0-9]){3,18}[a-zA-Z0-9]$]"],
                                "constraints" => [
                                    new NotBlank([
                                        "message"=> "Please, complete the field !"]),
                    ]])

            ->add('name', TextType::class, [
                "attr"=> [
                    "class"=>
                        "input is-rounded is-danger"]])

            ->add('firstname', TextType::class, [
                "attr"=> [
                    "class"=>
                        "input is-rounded is-danger"]])

            ->add('phone', TelType::class, [
                "attr"=> [
                    "class"=>
                        "input is-rounded is-danger",
                            "pattern"=>"[0-9]{10}",
                                "maxlength"=>"10"],
                ])

            ->add('email', EmailType::class, [
                "attr"=> [
                    "class"=>
                        "input is-rounded is-danger",
                            "pattern"=> "^[^\W][a-zA-Z0-9\-\._]+[^\W]@[^\W][a-zA-Z0-9\-\._]+[^\W]\.[a-zA-Z]{2,6}$"]
                ])

            ->add('password', PasswordType::class, [
                "attr"=> [
                    "class"=>
                        "input is-rounded is-danger"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
