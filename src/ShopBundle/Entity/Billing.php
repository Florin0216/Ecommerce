<?php

namespace ShopBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ShopBundle\Repository\BillingRepository;
use Symfony\Component\Serializer\Attribute\Groups;
use UserBundle\Entity\User;

#[ORM\Entity(repositoryClass: BillingRepository::class)]
#[ORM\Table(name: 'shop__billing')]
class Billing
{
    const ENTITY_ALIAS = 'bil';

    const NORMALIZER_GROUPS = ['bil.details'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups('bil.details')]
    protected ?int $id;

    #[ORM\Column(type: Types::STRING, length: 64)]
    #[Groups('bil.details')]
    protected ?string $firstName = null;

    #[ORM\Column(type: Types::STRING, length: 64)]
    #[Groups('bil.details')]
    protected ?string $lastName = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups('bil.details')]
    protected ?string $address = null;

    #[ORM\Column(type: Types::STRING, length: 64)]
    #[Groups('bil.details')]
    protected ?string $city = null;

    #[ORM\Column(type: Types::STRING, length: 64)]
    #[Groups('bil.details')]
    protected ?string $country = null;

    #[ORM\Column(type: Types::INTEGER)]
    #[Groups('bil.details')]
    protected ?int $postalCode = null;

    #[ORM\Column(type: Types::INTEGER)]
    #[Groups('bil.details')]
    protected ?int $phoneNumber = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    protected ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): Billing
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): Billing
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): Billing
    {
        $this->address = $address;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): Billing
    {
        $this->city = $city;
        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): Billing
    {
        $this->country = $country;
        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(?int $postalCode): Billing
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?int $phoneNumber): Billing
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): Billing
    {
        $this->user = $user;
        return $this;
    }

}
