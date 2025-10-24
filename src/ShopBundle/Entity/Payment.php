<?php

namespace ShopBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ShopBundle\Repository\PaymentRepository;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
#[ORM\Table(name: 'shop__payment')]
class Payment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    protected ?int $id;

    #[ORM\Column(type: Types::FLOAT)]
    protected ?float $amount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): Payment
    {
        $this->amount = $amount;
        return $this;
    }

}
