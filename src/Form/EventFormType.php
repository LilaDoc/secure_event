<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class EventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label'       => 'Titre de l\'événement',
                'constraints' => [new NotBlank(['message' => 'Le titre est obligatoire.'])],
                'attr'        => ['placeholder' => 'Ex: Concert de jazz'],
            ])
            ->add('description', TextareaType::class, [
                'label'       => 'Description',
                'constraints' => [
                    new NotBlank(['message' => 'La description ne peut pas être vide.']),
                ],
                'attr' => [
                    'placeholder' => 'Décrivez l\'événement...',
                    'rows'        => 4,
                ],
            ])
            ->add('dateDebut', DateTimeType::class, [
                'label'       => 'Date et heure de début',
                'widget'      => 'single_text',
                'constraints' => [
                    new NotBlank(['message' => 'La date est obligatoire.']),
                    new GreaterThan([
                        'value'   => 'today',
                        'message' => 'La date doit être dans le futur.',
                    ]),
                ],
            ])
            ->add('lieu', TextType::class, [
                'label'       => 'Lieu',
                'constraints' => [new NotBlank(['message' => 'Le lieu est obligatoire.'])],
                'attr'        => ['placeholder' => 'Ex: Salle Pleyel, Paris'],
            ])
            ->add('capaciteMax', IntegerType::class, [
                'label'       => 'Capacité maximale',
                'constraints' => [
                    new NotBlank(['message' => 'La capacité est obligatoire.']),
                    new Positive(['message' => 'La capacité doit être un nombre positif.']),
                ],
                'attr' => ['placeholder' => 'Ex: 200', 'min' => 1],
            ])
            ->add('isPublished', CheckboxType::class, [
                'label'    => 'Publier l\'événement',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
