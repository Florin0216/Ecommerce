<?php

namespace ShopBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ShopBundle\Repository\CartItemRepository;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: CartItemRepository::class)]
#[ORM\Table(name: 'shop__cart_item')]
class CartItem
{
    const ENTITY_ALIAS = 'ctm';

    const NORMALIZER_GROUPS = ['ctm.details','product.details', 'cart.details'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups('ctm.details')]
    protected ?int $id = null;

    #[ORM\Column(type: Types::INTEGER)]
    #[Groups('ctm.details')]
    protected ?int $quantity = null;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[Groups('product.details')]
    protected ?Product $product = null;

    #[ORM\ManyToOne(targetEntity: Cart::class)]
    #[Groups('cart.details')]
    protected ?Cart $cart = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): CartItem
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): CartItem
    {
        $this->product = $product;
        return $this;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): CartItem
    {
        $this->cart = $cart;
        return $this;
    }

}
