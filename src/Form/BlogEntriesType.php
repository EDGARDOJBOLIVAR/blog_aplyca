<?php

namespace App\Form;

use App\Entity\BlogEntries;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class BlogEntriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class , ['label' => 'Titulo', 'attr' => ['class' => 'form-control']])
            ->add('text', TextareaType::class, ['label' => 'Contenido', 'attr' => ['class' => 'form-control']])
            ->add('image', FileType::class, [
                'label' => 'Seleccione imagen', 
                'mapped' => false, 
                'required' => false, 
                'constraints' => [
                    new File([
                        'maxSize' => '5024k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Solo se permiten imagenes (jpeg, jpg, png)',
                    ])
                ],
                'attr' => ['class' => 'form-control']
            ])
            ->add('Registrar', SubmitType::class, ['attr' => ['class' => 'btn btn-success mt-2']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BlogEntries::class,
        ]);
    }
}
