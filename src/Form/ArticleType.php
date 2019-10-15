<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{

    /**
     * Permet d'avoir la configuration de base d'un champ !
     *
     * @param string $label
     * @param string $placeholder
     * @param array $options
     * @return array
     */
    private function getConfiguration($label, $placeholder, $options = []){
        return array_merge([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ], $options);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle',
            TextType::class,
            $this->getConfiguration("Libelle", "Tapez un nom pour votre article"))
            ->add('prix',
            MoneyType::class,
            $this->getConfiguration("Prix", "Indiquez un prix pour votre article"))
            ->add('image',
            ImageType::class,
            $this->getConfiguration('images',CollectionType::class,[
                'entry_type'=>ImageType::class,
                'allow_add' => true,
                'allow_delete' => true
            ]))
            ->add('description',
            TextareaType::class,
            $this->getConfiguration("Description", "Tapez une description pour votre article"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
