<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[ORM\Table(name: '`projects`')]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private $project_name;

    #[ORM\Column(type: 'string', length: 1000, nullable: true)]
    private $project_description;

    #[ORM\OneToMany(mappedBy: 'project_id', targetEntity: Task::class, cascade: ['remove'])]
    private $tasks;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    private $team_id;

    #[ORM\OneToMany(mappedBy: 'team_id', targetEntity: self::class)]
    private $projects;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->projects = new ArrayCollection();
    }

    public function getProjectId(): ?int
    {
        return $this->id;
    }

    public function getProjectName(): ?string
    {
        return $this->project_name;
    }

    public function setProjectName(string $project_name): self
    {
        $this->project_name = $project_name;

        return $this;
    }

    public function getProjectDescription(): ?string
    {
        return $this->project_description;
    }

    public function setProjectDescription(string $project_description): self
    {
        $this->project_description = $project_description;

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setProjectId($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getProjectId() === $this) {
                $task->setProjectId(null);
            }
        }

        return $this;
    }

    public function getTeamId(): ?self
    {
        return $this->team_id;
    }

    public function setTeamId(?self $team_id): self
    {
        $this->team_id = $team_id;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(self $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->setTeamId($this);
        }

        return $this;
    }

    public function removeProject(self $project): self
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getTeamId() === $this) {
                $project->setTeamId(null);
            }
        }

        return $this;
    }
}
