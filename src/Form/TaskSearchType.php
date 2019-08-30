<?php

namespace App\Form;

use App\Entity\TaskSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TaskSearchType
 *
 * @package App\Form
 */
class TaskSearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('minDate', DateType::class, [
                'widget'   => 'single_text',
                'html5'    => false,
                'format' => 'dd-M-yyyy H:mm',
                'required' => false
            ])
            ->add('maxDate', DateType::class, [
                'widget'   => 'single_text',
                'html5'    => false,
                'format' => 'dd-M-yyyy H:mm',
                'required' => false

            ])
            ->add('isCompleted', ChoiceType::class, [
                'choices'  => [
                    'Yes' => true,
                    'No' => false,
                ],
                'required' => false

            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
                                   'data_class'      => TaskSearch::class,
                                   'method'          => 'get',
                                   'csrf_protection' => false
                               ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return '';
    }
}
