<?php

namespace ShopBundle\Entity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ShopBundle\Repository\DeliveryRepository;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: DeliveryRepository::class)]
#[ORM\Table('shop__delivery')]
class Delivery
{
    const ENTITY_ALIAS = 'dlv';

    const NORMALIZER_GROUPS = ['delivery.details'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups('delivery.details')]
    protected ?int $id;

    #[ORM\Column(type: Types::STRING, length: 64)]
    #[Groups('delivery.details')]
    protected ?string $name = null;

    #[ORM\Column(type: Types::FLOAT)]
    #[Groups('delivery.details')]
    protected ?float $price = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): Delivery
    {
        $this->name = $name;
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): Delivery
    {
        $this->price = $price;
        return $this;
    }

}
