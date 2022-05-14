<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`users`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private $user_name;

    #[ORM\Column(type: 'string', length: 255)]
    private $user_password;

    #[ORM\Column(type: 'string', length: 255, unique: true, nullable: true)]
    private $user_email;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private $user_verified;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $user_image;

    #[ORM\Column(type: 'string', length: 255, unique: true, nullable: true)]
    private $telegram;

    #[ORM\Column(type: 'integer', options: ['default' => 1])]
    private $role;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Comment::class, cascade: ['remove'])]
    private $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getUserId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->user_name;
    }

    public function setUserName(string $user_name): self
    {
        $this->user_name = $user_name;

        return $this;
    }

    public function getUserPassword(): ?string
    {
        return $this->user_password;
    }

    public function setUserPassword(string $user_password): self
    {
        $this->user_password = $user_password;

        return $this;
    }

    public function getUserEmail(): ?string
    {
        return $this->user_email;
    }

    public function setUserEmail(?string $user_email): self
    {
        $this->user_email = $user_email;

        return $this;
    }

    public function getUserVerified(): ?bool
    {
        return $this->user_verified;
    }

    public function setUserVerified(bool $user_verified): self
    {
        $this->user_verified = $user_verified;

        return $this;
    }

    public function getUserImage(): ?string
    {
        return $this->user_image;
    }

    public function setUserImage(?string $user_image): self
    {
        $this->user_image = $user_image;

        return $this;
    }

    public function getTelegram(): ?string
    {
        return $this->telegram;
    }

    public function setTelegram(?string $telegram): self
    {
        $this->telegram = $telegram;

        return $this;
    }

    public function getRoleId(): ?int
    {
        return $this->role;
    }

    public function setRoleId(int $role_id): self
    {
        $this->role = $role_id;

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
            $comment->setUserId($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUserId() === $this) {
                $comment->setUserId(null);
            }
        }

        return $this;
    }
}
