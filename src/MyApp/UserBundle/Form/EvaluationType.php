<?php

namespace MyApp\UserBundle\Form;

use blackknight467\StarRatingBundle\Form\RatingType;
use DS\Component\ReCaptchaValidator\Form\ReCaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class EvaluationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rating',RatingType::class, ['label' => 'Noter cette experience'])
            ->add('avis',TextareaType::class, array(
                'attr'=>array('class'=>'form-control'),
                'required'=>false,
                'label'=>'Rédiger un avis bref'))
            ->add('captcha', ReCaptchaType::class, array('mapped' => false));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MyApp\UserBundle\Entity\Evaluation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'myapp_userbundle_evaluation';
    }


}
