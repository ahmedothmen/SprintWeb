<?php

namespace ProprieteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProprieteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categoriepropriete',ChoiceType::class,array('attr'=>array('class'=>'select-box'),'choices'=>array('Maison'=>'Maison','Appartement'=>'Appartement')))
            ->add('typepropriete',ChoiceType::class,array('attr'=>array('class'=>'select-box'),'choices'=>array('Chambre(s) Privee(s)'=>'Chambre(s) Privee(s)','Chambre(s) entier(s'=>'Chambre(s) entier(s')))
            ->add('pays')
            ->add('ville')
            ->add('rue')
            ->add('titre')
            ->add('prix')
            ->add('nbrchambre')
            ->add('nbrvoyageur')
            ->add('description')
            ->add('animaux')
            ->add('fumeur')
            ->add('alcool')
            ->add('enfant');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProprieteBundle\Entity\Propriete'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'proprietebundle_propriete';
    }


}
