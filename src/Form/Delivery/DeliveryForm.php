<?php

namespace App\Form\Delivery;

use App\Entity\Delivery\Delivery;
use App\Entity\Supplier\Supplier;
use App\Entity\User\BaseUser;
use App\Entity\Warehouse\Warehouse;
use App\Form\Core\DefaultForm\EditForm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class DeliveryForm extends EditForm
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder            
            ->add('deliveryDate', DateType::class, [
                'label' => 'deliveryDate',
                'required' => true,
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['data-datepicker' => '{}'],
                'input' => 'datetime_immutable',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('supplier', EntityType::class, [
                'class' => Supplier::class,
                'label' => 'supplier',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
                'choice_label' => function (Supplier $entity) {
                    return $entity->getName();
                },
                'placeholder' => 'chooseSupplier',
                'attr' => [
                    'class' => 'select2',
                ]
            ])
            ->add('warehouse', EntityType::class, [
                'class' => Warehouse::class,
                'label' => 'warehouse',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
                'choice_label' => function (Warehouse $entity) {
                    return $entity->getName();
                },
                'placeholder' => 'chooseWarehouse',
                'attr' => [
                    'class' => 'select2',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Delivery::class,
            'translation_domain' => 'delivery',
        ]);
    }
} 