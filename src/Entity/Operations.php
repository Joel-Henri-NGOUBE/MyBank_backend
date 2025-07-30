<?php

namespace App\Entity;

use App\Entity\User;
use App\Controller\CreateOperationController;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\OperationsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;
// use Gedmo\Mapping\Annotation\Timestampable;

#[ORM\Entity(repositoryClass: OperationsRepository::class)]
#[ApiResource(
    uriTemplate: '/users/{user_id}/operations', 
    uriVariables: [
        "user_id" => new Link(fromClass: User::class, toProperty: "user")], 
    // name: "api_create_operation",
    operations: [new Post()],
    controller:  CreateOperationController::class
        
    )]
#[ApiResource(
    uriTemplate: '/users/{user_id}/operations/{id}', 
    uriVariables: [
        "user_id" => new Link(fromClass: User::class, toProperty: "user"), 
        "id" => new Link(fromClass: Operations::class)], 
    // name: "api_retrieve_operation",
    operations: [new Get()]   
    )]
#[ApiResource(
    uriTemplate: '/users/{user_id}/operations', 
    uriVariables: [
        "user_id" => new Link(fromClass: User::class, toProperty: "user"), 
        // "id" => new Link(fromClass: Operations::class)
    ], 
    // name: "api_retrieve_operation",
    operations: [new GetCollection()]   
    )]
#[ApiResource(
    uriTemplate: '/users/{user_id}/operations/{id}', 
    uriVariables: [
        "user_id" => new Link(fromClass: User::class, toProperty: "user"), 
        "id" => new Link(fromClass: Operations::class)], 
    // name: "api_set_operation",
    operations: [new Patch()]   
    )]
#[ApiResource(
    uriTemplate: '/users/{user_id}/operations/{id}', 
    uriVariables: [
        "user_id" => new Link(fromClass: User::class, toProperty: "user"), 
        "id" => new Link(fromClass: Operations::class)], 
    // name: "api_delete_operation",
    operations: [new Delete()] 
)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
)]
// #[ApiResource(
//     // uriTemplate: '/users/{user_id}/operations/{id}', 
//     // uriVariables: [
//     //     "user_id" => new Link(fromClass: User::class, toProperty: "user"), 
//     //     "id" => new Link(fromClass: Operations::class)],
//     operations: [
//         // new GetCollection(
//         //     uriTemplate: '/users/{user_id}/operations', 
//         //     itemUriTemplate: '/users/{user_id}/operations', 
//         //     uriVariables: [
//         //         "user_id" => new Link(fromClass: User::class, toProperty: "user"), 
//         //         // "id" => new Link(fromClass: Operations::class)
//         //     ], 
//         //     name: "api_retrieve_operation"
//         // ),
//         new Post(
//             uriTemplate: '/users/{user_id}/operations', 
//             uriVariables: [
//                 "user_id" => new Link(fromClass: User::class, toProperty: "user")], 
//             name: "api_create_operation"
//         ),
        
//         new Get(
//             uriTemplate: '/users/{user_id}/operations/{id}', 
//             uriVariables: [
//                 "user_id" => new Link(fromClass: User::class, toProperty: "user"), 
//                 "id" => new Link(fromClass: Operations::class)], 
//             name: "api_retrieve_operation"
//         ),
//         // // new GetCollection(uriTemplate: '/users/{user_id}/operations', uriVariables: ["user_id" => new Link(fromClass: User::class, toProperty: "user")], name: "api_create_operation"),
//         // // new Post(uriTemplate: '/users/{user_id}/operations', uriVariables: ["user_id" => new Link(fromClass: User::class, toClass: Operations::class, fromProperty: "operations", toProperty: "user")], name: "api_create_operation"),
//         new Patch(
//             uriTemplate: '/users/{user_id}/operations/{id}', 
//             uriVariables: [
//                 "user_id" => new Link(fromClass: User::class, toProperty: "user"), 
//                 "id" => new Link(fromClass: Operations::class)], 
//             name: "api_set_operation"
//         ),
//         new Delete(
//             uriTemplate: '/users/{user_id}/operations/{id}', 
//             uriVariables: [
//                 "user_id" => new Link(fromClass: User::class, toProperty: "user"), 
//                 "id" => new Link(fromClass: Operations::class)], 
//             name: "api_delete_operation"
//         ),
//         // // new Get(uriTemplate: '/users/{user_id}/operations/{id}', controller: GetWeather::class),
//         // // new GetCollection(),
//     ])
// ]
class Operations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["read"])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(["read", "write"])]
    private ?string $label = null;

    #[ORM\Column]
    #[Groups(["read", "write"])]
    private ?float $amount = null;

    #[ORM\Column(enumType: Type::class)]
    #[Groups(["read", "write"])]
    private ?Type $type = null;

    #[ORM\Column(enumType: Category::class)]
    #[Groups(["read", "write"])]
    private ?Category $category = null;

    #[ORM\Column]
    #[Groups(["read", "write"])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'operations')]
    #[ORM\JoinColumn(nullable: false)]
    // #[ORM\JoinColumn(nullable: false, name: "user_id", referencedColumnName: 'id', unique: true)]
    #[Groups(["read", "write"])]
    private ?User $user = null;

    public function __construct() {
        $this->createdAt = new \DateTimeImmutable();
        // var_dump($this->user);
        // $this->setUser(new User());
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
