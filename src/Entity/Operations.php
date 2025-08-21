<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\CreateOperationController;
use App\Repository\OperationsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OperationsRepository::class)]
// Defines the route that adds an operation
#[ApiResource(
    uriTemplate: '/users/{user_id}/operations',
    uriVariables: [
        'user_id' => new Link(fromClass: User::class, toProperty: 'user'),
    ],
    operations: [new Post()],
    controller: CreateOperationController::class
)]

// Defines the route that gets an operation
#[ApiResource(
    uriTemplate: '/users/{user_id}/operations/{id}',
    uriVariables: [
        'user_id' => new Link(fromClass: User::class, toProperty: 'user'),
        'id' => new Link(fromClass: Operations::class),
    ],
    operations: [new Get()]
)]

// Defines the route that gets all the operations
#[ApiResource(
    uriTemplate: '/users/{user_id}/operations',
    uriVariables: [
        'user_id' => new Link(fromClass: User::class, toProperty: 'user'),
    ],
    operations: [new GetCollection()]
)]

// Defines the route that sets an operation
#[ApiResource(
    uriTemplate: '/users/{user_id}/operations/{id}',
    uriVariables: [
        'user_id' => new Link(fromClass: User::class, toProperty: 'user'),
        'id' => new Link(fromClass: Operations::class),
    ],
    operations: [new Patch()]
)]

// Defines the route that deletes an operation
#[ApiResource(
    uriTemplate: '/users/{user_id}/operations/{id}',
    uriVariables: [
        'user_id' => new Link(fromClass: User::class, toProperty: 'user'),
        'id' => new Link(fromClass: Operations::class),
    ],
    operations: [new Delete()]
)]

// Defining serializer options
#[ApiResource(
    normalizationContext: [
        'groups' => ['read'],
    ],
    denormalizationContext: [
        'groups' => ['write'],
    ],
)]

class Operations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['read', 'write'])]
    private ?string $label = null;

    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?float $amount = null;

    #[ORM\Column(enumType: Type::class)]
    #[Groups(['read', 'write'])]
    private ?Type $type = null;

    #[ORM\Column(enumType: Category::class)]
    #[Groups(['read', 'write'])]
    private ?Category $category = null;

    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'operations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(Type $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
