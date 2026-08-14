<?php

namespace App\Form\Delivery;

use App\Entity\Delivery\Delivery;
use App\Entity\Product\Product;
use App\Form\Core\DefaultForm\SearchForm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DeliveryItemSearchForm extends SearchForm {

    public function __construct(
        private RequestStack $requestStack,
        private UrlGeneratorInterface $router
    ) {

    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
        $builder
            ->add('delivery', EntityType::class, [
                'class' => Delivery::class,
                'required' => false,
                'placeholder' => 'allDeliveries',
                'choice_label' => function (Delivery $entity) {
                    return 'Delivery #' . $entity->getId() . ' - ' . $entity->getDeliveryDate()->format('d.m.Y');
                },
                'attr' => [
                    'class' => 'select2',
                ]
            ])
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'required' => false,
                'placeholder' => 'allProducts',
                'choice_label' => function (Product $entity) {
                    return $entity->getName();
                },
                'attr' => [
                    'class' => 'select2',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $request = $this->requestStack->getCurrentRequest();
        if ($request) {
            $resolver->setDefault('action', $this->router->generate($request->get('_route'),
                array_merge($request->get('_route_params'), ['page'=>1])));
        }
        $resolver->setDefault('translation_domain', 'delivery_item');
    }
} 