<?php

namespace ShopBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ShopBundle\Repository\ShippingRepository;
use Symfony\Component\Serializer\Attribute\Groups;
use UserBundle\Entity\User;

#[ORM\Entity(repositoryClass: ShippingRepository::class)]
#[ORM\Table(name: 'shop__shipping')]
class Shipping
{
    const ENTITY_ALIAS = 'shp';

    const NORMALIZER_GROUPS = ['shp.details'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups('shp.details')]
    protected ?int $id;

    #[ORM\Column(type: Types::STRING, length: 64)]
    #[Groups('shp.details')]
    protected ?string $firstName = null;

    #[ORM\Column(type: Types::STRING, length: 64)]
    #[Groups('shp.details')]
    protected ?string $lastName = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups('shp.details')]
    protected ?string $address = null;

    #[ORM\Column(type: Types::STRING, length: 64)]
    #[Groups('shp.details')]
    protected ?string $city = null;

    #[ORM\Column(type: Types::STRING, length: 64)]
    #[Groups('shp.details')]
    protected ?string $country = null;

    #[ORM\Column(type: Types::INTEGER)]
    #[Groups('shp.details')]
    protected ?int $postalCode = null;

    #[ORM\Column(type: Types::INTEGER)]
    #[Groups('shp.details')]
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

    public function setFirstName(?string $firstName): Shipping
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): Shipping
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): Shipping
    {
        $this->address = $address;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): Shipping
    {
        $this->city = $city;
        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): Shipping
    {
        $this->country = $country;
        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(?int $postalCode): Shipping
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?int $phoneNumber): Shipping
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): Shipping
    {
        $this->user = $user;
        return $this;
    }

}
