<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ORM\Table(name: '`tasks`')]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private $task_key;

    #[ORM\Column(type: 'string', length: 255)]
    private $task_title;

    #[ORM\Column(type: 'string', length: 1500, nullable: true)]
    private $task_description;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private $is_completed;

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[ORM\Column(type: 'integer')]
    private $user_id;

    #[ORM\Column(type: 'integer')]
    private $type_id;

    #[ORM\Column(type: 'integer')]
    private $status_id;

    #[ORM\OneToMany(mappedBy: 'task_id', targetEntity: File::class, cascade: ['remove'])]
    private $files;

    #[ORM\ManyToOne(targetEntity: Project::class, inversedBy: 'tasks')]
    private $project;

    #[ORM\OneToMany(mappedBy: 'task_id', targetEntity: Comment::class, cascade: ['remove'])]
    private $comments;

    public function __construct()
    {
        $this->files = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaskKey(): ?string
    {
        return $this->task_key;
    }

    public function setTaskKey(string $task_key): self
    {
        $this->task_key = $task_key;

        return $this;
    }

    public function getTaskTitle(): ?string
    {
        return $this->task_title;
    }

    public function setTaskTitle(string $task_title): self
    {
        $this->task_title = $task_title;

        return $this;
    }

    public function getTaskDescription(): ?string
    {
        return $this->task_description;
    }

    public function setTaskDescription(string $task_description): self
    {
        $this->task_description = $task_description;

        return $this;
    }

    public function getIsCompleted(): ?bool
    {
        return $this->is_completed;
    }

    public function setIsCompleted(bool $is_completed): self
    {
        $this->is_completed = $is_completed;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getTypeId(): ?int
    {
        return $this->type_id;
    }

    public function setTypeId(int $type_id): self
    {
        $this->type_id = $type_id;

        return $this;
    }

    public function getStatusId(): ?int
    {
        return $this->status_id;
    }

    public function setStatusId(int $status_id): self
    {
        $this->status_id = $status_id;

        return $this;
    }

    public function getProjectId(): ?Project
    {
        return $this->project;
    }

    public function setProjectId(?Project $project_id): self
    {
        $this->project = $project_id;

        return $this;
    }

    /**
     * @return Collection<int, File>
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(File $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files[] = $file;
            $file->setTaskId($this);
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        if ($this->files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getTaskId() === $this) {
                $file->setTaskId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setTaskId($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTaskId() === $this) {
                $comment->setTaskId(null);
            }
        }

        return $this;
    }
}
