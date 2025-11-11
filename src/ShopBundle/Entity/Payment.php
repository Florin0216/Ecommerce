<?php

namespace ShopBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ShopBundle\Repository\PaymentRepository;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
#[ORM\Table(name: 'shop__payment')]
class Payment
{
    const ENTITY_ALIAS = 'pmt';

    const NORMALIZER_GROUPS = ['payment.details'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups('payment.details')]
    protected ?int $id;

    #[ORM\Column(type: Types::STRING, length: 3, nullable: true)]
    #[Groups('payment.details')]
    protected ?string $currency = null;

    #[ORM\Column(type: Types::STRING, length: 16)]
    #[Groups('payment.details')]
    protected ?string $status = null;

    #[ORM\Column(type: Types::STRING, length: 32)]
    #[Groups('payment.details')]
    protected ?string $method = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): Payment
    {
        $this->currency = $currency;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): Payment
    {
        $this->status = $status;
        return $this;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(?string $method): Payment
    {
        $this->method = $method;
        return $this;
    }

}
