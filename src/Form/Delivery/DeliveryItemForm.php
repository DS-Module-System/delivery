<?php

namespace App\Form\Delivery;

use App\Entity\Delivery\Delivery;
use App\Entity\Delivery\DeliveryItem;
use App\Entity\Product\Product;
use App\Form\Core\DefaultForm\EditForm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class DeliveryItemForm extends EditForm
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder            
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'label' => 'product',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
                'choice_label' => function (Product $entity) {
                    return $entity->getName();
                },
                'placeholder' => 'chooseProduct',
                'attr' => [
                    'class' => 'select2',
                ] 
            ])
            ->add('quantity', NumberType::class, [
                'label' => 'quantity',
                'required' => true,
                'scale' => 2,
                'constraints' => [
                    new NotBlank(),
                    new Positive(),
                ],
                'attr' => [
                    'step' => '0.01',
                    'min' => '0.01',
                ],
            ])
            ->add('pricePerItem', NumberType::class, [
                'label' => 'pricePerItem',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Positive(),
                ],
                'scale' => 2,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DeliveryItem::class,
            'translation_domain' => 'delivery_item',
        ]);
    }
} 