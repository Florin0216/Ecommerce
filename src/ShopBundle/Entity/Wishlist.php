<?php

namespace ShopBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ShopBundle\Repository\WishlistRepository;
use Symfony\Component\Serializer\Attribute\Groups;
use UserBundle\Entity\User;

#[ORM\Entity(repositoryClass: WishlistRepository::class)]
#[ORM\Table(name: 'shop__wishlist')]
class Wishlist
{
    const ENTITY_ALIAS = 'wsh';

    const NORMALIZER_GROUPS = ['wishlist.details', 'user.details'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups('wishlist.details')]
    protected ?int $id;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', unique: true, nullable: false)]
    #[Groups('user.details')]
    protected ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): Wishlist
    {
        $this->user = $user;
        return $this;
    }
}
