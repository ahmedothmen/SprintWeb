<?php
namespace MyAppMailBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class MailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
{ $builder
    ->add('email', EmailType::class)
    ->add('text', TextareaType::class,array(
        'required'=>false))
    ->add('valider', SubmitType::class) ; }
    public function getName()
    { return 'Mail'; }
}