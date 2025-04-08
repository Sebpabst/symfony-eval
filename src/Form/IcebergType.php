<?php

namespace App\Form;

use App\Entity\Iceberg;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Sequentially;

class IcebergType extends AbstractType
{

    public function __construct(private FormListenerFactory $listenerFactory)
    {

    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'empty_data' => ''
            ])
            ->add('slug', TextType::class, [
                'required' => false
                // 'constraints' => new Sequentially([ // Sequentially va afficher d'abord le 1er message d'erreur et dès que l'utilisateur aura corriger ça va afficher le 2ème
                //     new Length(min:10), // Doit contenir au moins 10 caractères
                //     new Regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', message: "Un slug ne doit pas contenir de caractères spéciaux")
                //     ])
            ])
            ->add('text', TextareaType::class, [
                'empty_data' => ''
            ])
            ->add('save', SubmitType::class,[
                'label' => 'Publier'
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->listenerFactory->autoSlug('title')) // Céer un collable a partir de la méthode autoSlug()
            // addEventListener est une fonction qui s'éxecute automatiquement lorsqu'un évènement se produit
            // FormEvents::PRE_SUBMIT est un événement de Symfony déclenché juste avant la soumission du formulaire.
            // Elle reçoit l’événement en paramètre, ce qui lui permet de modifier les données du formulaire avant qu'elles ne soient validées.
            ->addEventListener(FormEvents::POST_SUBMIT, $this->listenerFactory->timestamps())
        ;
    }

    public function autoSlug(PreSubmitEvent $event): void{ // Intéragir avec les données soumises avant leur traitement
        $data = $event->getData(); // Récupère les données sous forme de tableau associatif
        if(empty($data['slug'])){ // Si le champ slug est vide
            $slugger = new AsciiSlugger(); // Il crée une instance de AsciiSlugger (un objet basé sur le modèle de la classe AsciiSlugger)
            $data['slug'] = strtolower($slugger->slug($data['titre'])); // Générer un slug a partir du champ 'titre' et met tout en minuscule
            $event->setData($data); // Met a jour le formulaire avec le slug généré
        }
    }

    public function attachTimestamps(PostSubmitEvent $event){
        $data = $event->getData();
        if(!($data instanceof Iceberg)){
            return;
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Iceberg::class, // Traiter un objet de type iceberg
            // 'validation_groups' => ['Default', 'Extra'] // Lui demander d'utiliser que les validations par défauts et celles du groupe 'Extra', et pas celles qui sont dans des groupes différents
        ]);
    }

    
}
