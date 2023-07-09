<?php

namespace App\Entity;

use App\Repository\ExcelDataRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ExcelDataRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource]
#[Get(normalizationContext: ['groups' => ['data:read']])]
#[Patch(denormalizationContext: ['groups' => ['data:update']])]
#[Delete]
#[Post(denormalizationContext: ['groups' => ['data:create']])]
class ExcelData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['data:create', 'data:read', 'user:read'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['data:create', 'data:read', 'data:update'])]
    private array $data = [];

    #[ORM\Column]
    #[Groups(['data:create', 'data:read'])]
    private array $fields = [];

    #[ORM\ManyToOne(inversedBy: 'excelDatas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
    
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): static
    {
        $this->data = $data;

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

    public function getFields(): array
    {
        return $this->fields;
    }

    public function setFields(array $fields): static
    {
        $this->fields = $fields;

        return $this;
    }
}
