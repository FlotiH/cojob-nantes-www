<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('last_name', null, [
                'label' => 'contact.form.last_name.label',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'contact.form.last_name.not_blank',
                    ]),
                ],
                'attr' => ['placeholder' => 'contact.form.last_name.placeholder', 'class' => 'form-control'],
            ])
            ->add('first_name', null, [
                'label' => 'contact.form.first_name.label',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'contact.form.first_name.not_blank',
                    ]),
                ],
                'attr' => ['placeholder' => 'contact.form.first_name.placeholder', 'class' => 'form-control'],
            ])
            ->add('email', EmailType::class, [
                'label' => 'contact.form.email.label',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'contact.form.email.not_blank',
                    ]),
                    new Email([
                        'message' => 'contact.form.email.check_mx',
                        'mode' => 'strict',
                    ]),
                ],
                'attr' => ['placeholder' => 'contact.form.email.placeholder', 'class' => 'form-control'],
            ])
            ->add('telephone', TelType::class, [
                'label' => 'contact.form.telephone.label',
                'required' => false,
                'attr' => ['placeholder' => 'contact.form.telephone.placeholder', 'class' => 'form-control'],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'contact.form.message.label',
                'required' => false,
                'attr' => [
                    'rows' => 5,
                    'placeholder' => 'contact.form.message.placeholder',
                    'class' => 'form-control',
                ],
            ])
            //honeypot
            ->add('name', HiddenType::class, [
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Contact',
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'app_contact';
    }
}
