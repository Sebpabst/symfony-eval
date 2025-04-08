<?php

namespace App\Form;

use App\Entity\Category;
use App\Form\FormEvents;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{

    public function __construct(private FormListenerFactory $listenerFactory)
    {

    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'empty_data' => ''
            ])
            ->add('slug', TextType::class, [
                'required' => false,
                'empty_data' => ''
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->listenerFactory->autoSlug('name')) // Céer un collable a partir de la méthode autoSlug()
            // addEventListener est une fonction qui s'éxecute automatiquement lorsqu'un évènement se produit
            // FormEvents::PRE_SUBMIT est un événement de Symfony déclenché juste avant la soumission du formulaire.
            // Elle reçoit l’événement en paramètre, ce qui lui permet de modifier les données du formulaire avant qu'elles ne soient validées.
            ->addEventListener(FormEvents::POST_SUBMIT, $this->listenerFactory->timestamps())
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
