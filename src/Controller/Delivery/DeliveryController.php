<?php

namespace App\Controller\Delivery;

use App\Controller\Core\CoreBaseController;
use App\Entity\Delivery\Delivery;
use App\Form\Delivery\DeliveryForm;
use App\Form\Delivery\DeliverySearchForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/deliveries', name: 'delivery_')]
class DeliveryController extends CoreBaseController
{
    
    protected string $entityClass = Delivery::class;
    protected string $formClass = DeliveryForm::class;
    protected string $searchFormClass = DeliverySearchForm::class;
    protected string $moduleTemplateName = 'delivery';

    #[Route(path: '', name: 'list')]
    #[IsGranted('ROLE_DELIVERY_VIEW')]
    public function list(Request $request): Response
    {
        $page = $request->get('page', 1);
        return $this->baseList($request, $page);
    }

    #[Route(path: '/create', name: 'create')]
    #[IsGranted('ROLE_DELIVERY_CREATE')]
    public function create(Request $request): Response
    {
        $this->callbacks['setDefaultEntityData'] = function (Delivery $row, array $additionalData, Request $request) {
            $row->setDeliveryDate(new \DateTimeImmutable());
            $row->setCreatedBy($this->getUser());
            return $row;
        };
        
        // when create completes, redirect to the edit page for the created entity
        $this->callbacks['redirectAfterCreate'] = function (Delivery $row) {
            return $this->redirectToRoute('delivery_edit', ['id' => $row->getId()]);
        };

        return $this->baseCreate($request);
    }

    #[Route(path: '/{id}/edit', name: 'edit')]
    #[IsGranted('ROLE_DELIVERY_EDIT')]
    public function edit($id, Request $request): Response
    {
        return $this->baseEdit($request, $id);
    }

    #[Route(path: '/deletes', name: 'deletes')]
    #[IsGranted('ROLE_DELIVERY_DELETE')]
    public function deletes(Request $request): Response
    {
        return $this->baseDeletes($request);
    }
} 