<?php

namespace ShopBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ShopBundle\Repository\WishlistItemRepository;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: WishlistItemRepository::class)]
#[ORM\Table(name: 'shop__wishlist_item')]
class WishlistItem
{
    const ENTITY_ALIAS = 'wtm';

    const NORMALIZER_GROUPS = ['wtm.details','product.details', 'wishlist.details'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups('wtm.details')]
    protected ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[Groups('product.details')]
    protected ?Product $product = null;

    #[ORM\ManyToOne(targetEntity: Wishlist::class)]
    #[Groups('wishlist.details')]
    protected ?Wishlist $wishlist = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): WishlistItem
    {
        $this->product = $product;
        return $this;
    }

    public function getWishlist(): ?Wishlist
    {
        return $this->wishlist;
    }

    public function setWishlist(?Wishlist $wishlist): WishlistItem
    {
        $this->wishlist = $wishlist;
        return $this;
    }

}
