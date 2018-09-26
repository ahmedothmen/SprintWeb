<?php

namespace Host\ExperienceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ExperienceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextareaType::class)
            ->add('type', ChoiceType::class, array(
                'choices'  => array(
                    'Type...' => 'None',
                    'Exotique' => 'Exotique',
                    'mexicaine' =>  'mexicaine',
                    'forestière' =>  'forestière',

                    'Montagne' =>'Montagne',
                    'Sahara' =>'Sahara',

                )))
            ->add('nom_xp')
            ->add('arrival')
            ->add('departure')
            ->add('participants', ChoiceType::class, array(
                'choices'  => array(
                    '1' => '1',
                    '2' => '2',
                    '3' =>  '3',
                    '4' =>  '4',

                    '5' =>'5',

                )))
            ->add('prix_xp')
            ->add('imageFile', VichImageType::class, [
      'required' => false,
      'allow_delete' => true, // optional, default is true
      'download_link' => true, // optional, default is true
  ])
            ->add("Submit",SubmitType::class);


    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Host\ExperienceBundle\Entity\Experience'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'host_experiencebundle_experience';
    }


}
