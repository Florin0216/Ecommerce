<?php

namespace ShopBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ShopBundle\Repository\OrderRepository;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use UserBundle\Entity\User;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: 'shop__order')]
#[ORM\HasLifecycleCallbacks]
class Order
{
    const ENTITY_ALIAS = 'order';

    const NORMALIZER_GROUPS = ['order.details', 'bil.details', 'shp.details', 'payment.details', 'delivery.details', 'user.details'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups(['order.details'])]
    protected ?int $id;

    #[ORM\Column(type: Types::FLOAT)]
    #[Groups(['order.details'])]
    protected ?float $total = null;

    #[ORM\Column(type: Types::STRING, length: 32)]
    #[Groups(['order.details'])]
    protected ?string $status = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d\TH:i'])]
    #[Groups(['order.details'])]
    protected ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[Groups('user.details')]
    protected ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Billing::class)]
    #[Groups(['bil.details'])]
    protected ?Billing $billing = null;

    #[ORM\ManyToOne(targetEntity: Delivery::class)]
    #[Groups(['delivery.details'])]
    protected ?Delivery $delivery = null;

    #[ORM\ManyToOne(targetEntity: Shipping::class)]
    #[Groups(['shp.details'])]
    protected ?Shipping $shipping = null;

    #[ORM\ManyToOne(targetEntity: Payment::class)]
    #[Groups(['payment.details'])]
    protected ?Payment $payment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): Order
    {
        $this->total = $total;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): Order
    {
        $this->status = $status;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): Order
    {
        $this->user = $user;
        return $this;
    }

    public function getBilling(): ?Billing
    {
        return $this->billing;
    }

    public function setBilling(?Billing $billing): Order
    {
        $this->billing = $billing;
        return $this;
    }

    public function getDelivery(): ?Delivery
    {
        return $this->delivery;
    }

    public function setDelivery(?Delivery $delivery): Order
    {
        $this->delivery = $delivery;
        return $this;
    }

    public function getShipping(): ?Shipping
    {
        return $this->shipping;
    }

    public function setShipping(?Shipping $shipping): Order
    {
        $this->shipping = $shipping;
        return $this;
    }

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    public function setPayment(?Payment $payment): Order
    {
        $this->payment = $payment;
        return $this;
    }

}
