<?php

namespace App\Entity;

use App\Repository\TaskPriorityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskPriorityRepository::class)]
class TaskPriority
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $priority_name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPriorityName(): ?string
    {
        return $this->priority_name;
    }

    public function setPriorityName(string $priority_name): self
    {
        $this->priority_name = $priority_name;

        return $this;
    }
}
