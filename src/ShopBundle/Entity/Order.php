<?php

namespace ShopBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ShopBundle\Repository\OrderRepository;
use Symfony\Component\Serializer\Attribute\Groups;
use UserBundle\Entity\User;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: 'shop__order')]
class Order
{
    const ENTITY_ALIAS = 'order';

    const NORMALIZER_GROUPS = ['order.details'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups(['order.details'])]
    protected ?int $id;

    #[ORM\Column(type: Types::FLOAT)]
    #[Groups(['order.details'])]
    protected ?float $total = null;

    #[ORM\Column(type: Types::STRING, length: 64)]
    #[Groups(['order.details'])]
    protected ?string $firstName = null;

    #[ORM\Column(type: Types::STRING, length: 64)]
    #[Groups(['order.details'])]
    protected ?string $lastName = null;

    #[ORM\Column(type: Types::STRING, length: 128)]
    #[Groups(['order.details'])]
    protected ?string $email = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['order.details'])]
    protected ?string $address = null;

    #[ORM\Column(type: Types::STRING, length: 64)]
    #[Groups(['order.details'])]
    protected ?string $city = null;

    #[ORM\Column(type: Types::STRING, length: 64)]
    #[Groups(['order.details'])]
    protected ?string $country = null;

    #[ORM\Column(type: Types::INTEGER)]
    #[Groups(['order.details'])]
    protected ?int $postalCode = null;

    #[ORM\Column(type: Types::INTEGER)]
    #[Groups(['order.details'])]
    protected ?int $phoneNumber = null;


    #[ORM\ManyToOne(targetEntity: User::class)]
    protected ?User $user = null;

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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): Order
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): Order
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): Order
    {
        $this->email = $email;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): Order
    {
        $this->address = $address;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): Order
    {
        $this->city = $city;
        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): Order
    {
        $this->country = $country;
        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(?int $postalCode): Order
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?int $phoneNumber): Order
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
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

}
