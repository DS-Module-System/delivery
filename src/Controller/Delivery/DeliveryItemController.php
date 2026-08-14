<?php

namespace App\Controller\Delivery;

use App\Controller\Core\CoreBaseController;
use App\Entity\Delivery\Delivery;
use App\Entity\Delivery\DeliveryItem;
use App\Form\Delivery\DeliveryItemForm;
use App\Form\Delivery\DeliveryItemSearchForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/delivery-items/{deliveryId}', name: 'delivery_item_')]
class DeliveryItemController extends CoreBaseController
{

    protected string $entityClass = DeliveryItem::class;
    protected string $formClass = DeliveryItemForm::class;
    protected string $searchFormClass = DeliveryItemSearchForm::class;
    protected string $moduleTemplateName = 'delivery_item';

    #[Route(path: '', name: 'list')]
    #[IsGranted('ROLE_DELIVERY_VIEW')]
    public function list(Request $request, int $deliveryId): Response
    {

        $delivery = $this->em->getRepository(Delivery::class)->find($deliveryId);
        if (!$delivery) {
            throw $this->createNotFoundException('Delivery not found');
        }

        $this->additionalData['delivery'] = $delivery;
        $this->appendSearchFormData['deliveryId'] = $delivery->getId();

        $page = $request->get('page', 1);
        return $this->baseList($request, $page);
    }

    #[Route(path: '/create', name: 'create')]
    #[IsGranted('ROLE_DELIVERY_CREATE')]
    public function create(Request $request, int $deliveryId): Response
    {
        $this->isModalRequest = true;

        $delivery = $this->em->getRepository(Delivery::class)->find($deliveryId);
        if (!$delivery) {
            throw $this->createNotFoundException('Delivery not found');
        }

        $this->additionalData['delivery'] = $delivery;
        $this->callbacks['setDefaultEntityData'] = function (DeliveryItem $deliveryItem, array $additionalData) {
            $deliveryItem->setDelivery($additionalData['delivery']);
            return $deliveryItem;
        };

        return $this->baseCreate($request);
    }

    #[Route(path: '/{id}/edit', name: 'edit')]
    #[IsGranted('ROLE_DELIVERY_EDIT')]
    public function edit($id, Request $request, int $deliveryId): Response
    {

        $this->isModalRequest = true;
        
        $delivery = $this->em->getRepository(Delivery::class)->find($deliveryId);
        if (!$delivery) {
            throw $this->createNotFoundException('Delivery not found');
        }

        $this->additionalData['delivery'] = $delivery;

        $deliveryItem = $this->em->getRepository(DeliveryItem::class)->find($id);
        if(!$deliveryItem || $deliveryItem->getDelivery()->getId() !== $delivery->getId()) {
            throw $this->createNotFoundException();
        }

        
        return $this->baseEdit($request, $id);
    }

    #[Route(path: '/deletes', name: 'deletes')]
    #[IsGranted('ROLE_DELIVERY_DELETE')]
    public function deletes(Request $request): Response
    {
        return $this->baseDeletes($request);
    }
} 