<?php

namespace ShopBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ShopBundle\Repository\OrderItemRepository;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
#[ORM\Table(name: 'shop__order_item')]
class OrderItem
{
    const ENTITY_ALIAS = 'otm';

    const NORMALIZER_GROUPS = ['otm.details'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups(['otm.details'])]
    protected ?int $id;

    #[ORM\Column(type: Types::INTEGER)]
    #[Groups(['otm.details'])]
    protected ?int $quantity = null;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[Groups(['otm.details'])]
    protected ?Product $product = null;

    #[ORM\ManyToOne(targetEntity: Order::class)]
    #[Groups(['otm.details'])]
    protected ?Order $order = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): OrderItem
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): OrderItem
    {
        $this->product = $product;
        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): OrderItem
    {
        $this->order = $order;
        return $this;
    }

}
