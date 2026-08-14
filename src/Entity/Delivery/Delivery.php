<?php

namespace App\Entity\Delivery;

use App\Entity\Core\CoreEntity;
use App\Entity\Delivery\DeliveryItem;
use App\Entity\Supplier\Supplier;
use App\Entity\User\BaseUser;
use App\Entity\Warehouse\Warehouse;
use App\Repository\Delivery\DeliveryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeliveryRepository::class)]
class Delivery implements CoreEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeInterface $deliveryDate = null;

    #[ORM\ManyToOne(targetEntity: BaseUser::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?BaseUser $createdBy = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\ManyToOne(targetEntity: Supplier::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Supplier $supplier = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $finalPrice = null;

    #[ORM\ManyToOne(targetEntity: Warehouse::class)]
    private ?Warehouse $warehouse = null;

    #[ORM\OneToMany(mappedBy: 'delivery', targetEntity: DeliveryItem::class, cascade: ['persist', 'remove'])]
    private \Doctrine\Common\Collections\Collection $items;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeliveryDate(): ?\DateTimeInterface
    {
        return $this->deliveryDate;
    }

    public function setDeliveryDate(?\DateTimeInterface $deliveryDate): self
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    public function getCreatedBy(): ?BaseUser
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?BaseUser $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(?Supplier $supplier): self
    {
        $this->supplier = $supplier;

        return $this;
    }

    public function getFinalPrice(): ?string
    {
        return $this->finalPrice;
    }

    public function setFinalPrice(?string $finalPrice): self
    {
        $this->finalPrice = $finalPrice;

        return $this;
    }

    public function getWarehouse(): ?Warehouse
    {
        return $this->warehouse;
    }

    public function setWarehouse(?Warehouse $warehouse): self
    {
        $this->warehouse = $warehouse;

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection<int, DeliveryItem>
     */
    public function getItems(): \Doctrine\Common\Collections\Collection
    {
        return $this->items;
    }

    public function addItem(DeliveryItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setDelivery($this);
        }

        return $this;
    }

    public function removeItem(DeliveryItem $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getDelivery() === $this) {
                $item->setDelivery(null);
            }
        }

        return $this;
    }
} 