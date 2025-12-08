<?php

namespace ShopBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ShopBundle\Repository\ReviewRepository;
use Symfony\Component\Serializer\Attribute\Groups;
use UserBundle\Entity\User;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
#[ORM\Table('shop__review')]
class Review
{
    const ENTITY_ALIAS = 'review';

    const NORMALIZER_GROUPS = ['review.details', 'user.details', 'product.details'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups('review.details')]
    protected ?int $id;

    #[ORM\Column(type: Types::INTEGER, length: 1)]
    #[Groups('review.details')]
    protected ?int $rating = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups('review.details')]
    protected ?string $comment = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', unique: true, nullable: false)]
    #[Groups('user.details')]
    protected ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[Groups('product.details')]
    protected ?Product $product = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): Review
    {
        $this->rating = $rating;
        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): Review
    {
        $this->comment = $comment;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): Review
    {
        $this->user = $user;
        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): Review
    {
        $this->product = $product;
        return $this;
    }

}
