<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,['label' => 'Název knihy'])
            ->add('description', TextareaType::class, ['label' => 'Popis', 'required' => false])
            ->add('year', IntegerType::class, [
                'attr' => [
                    'min' => -5000,
                    'max' => date("Y")
                ],
                'label' => 'Rok vydání',
                'data' => 2020]
            )
            ->add('numberOfPages', IntegerType::class, ['label' => 'Počet stran', 'data' => 100])
            ->add('author', null,['label' => 'Autor'])
            ->add('genres', null,['label' => 'Žánry'])
            ->add('submit', SubmitType::class, ['label' => 'Uložit knihu'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
