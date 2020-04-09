<?php

namespace App\Form;

use App\Entity\ContentType;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'name',
                'label' => false,
                'placeholder' => 'Choose the scope of the alternative',
                'required' => false,
                'attr' => [
                    'onChange' => 'this.form.submit()',
                ],
            ])
            ->add('contentType', EntityType::class, [
                'class' => ContentType::class,
                'choice_label' => 'name',
                'label' => false,
                'placeholder' => 'Choose the kind of alternative',
                'required' => false,
                'attr' => [
                    'onChange' => 'this.form.submit()',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        ]);
    }
}
