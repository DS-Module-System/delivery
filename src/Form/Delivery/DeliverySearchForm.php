<?php

namespace App\Form\Delivery;

use App\Entity\Warehouse\Warehouse;
use App\Form\Core\DefaultForm\SearchForm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DeliverySearchForm extends SearchForm {

    public function __construct(
        private RequestStack $requestStack,
        private UrlGeneratorInterface $router
    ) {

    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
        $builder
            ->add('supplier', TextType::class, [
                'required' => false,
                'label' => 'supplier'
            ])
            ->add('warehouse', EntityType::class, [
                'class' => Warehouse::class,
                'label' => 'warehouse',
                'required' => false,
                'choice_label' => function (Warehouse $entity) {
                    return $entity->getName();
                },
                'placeholder' => 'allWarehouses',
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
        $resolver->setDefault('translation_domain', 'delivery');
    }
} 