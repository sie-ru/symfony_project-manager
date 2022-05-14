<?php

namespace App\Entity;

use App\Repository\FileRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FileRepository::class)]
#[ORM\Table(name: '`files`')]
class File
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $file_path;

    #[ORM\ManyToOne(targetEntity: Task::class, inversedBy: 'files')]
    private $task;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilePath(): ?string
    {
        return $this->file_path;
    }

    public function setFilePath(string $file_path): self
    {
        $this->file_path = $file_path;

        return $this;
    }

    public function getTaskId(): ?Task
    {
        return $this->task_id;
    }

    public function setTaskId(?Task $task_id): self
    {
        $this->task = $task_id;

        return $this;
    }
}
