<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $instagramId;

    /**
     * @ORM\Column(type="datetime")
     */
    private $followedOn;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasFollowedBack;

    public function getId()
    {
        return $this->id;
    }

    public function getInstagramId(): ?int
    {
        return $this->instagramId;
    }

    public function setInstagramId(int $instagramId): self
    {
        $this->instagramId = $instagramId;

        return $this;
    }

    public function getFollowedOn(): ?\DateTimeInterface
    {
        return $this->followedOn;
    }

    public function setFollowedOn(\DateTimeInterface $followedOn): self
    {
        $this->followedOn = $followedOn;

        return $this;
    }

    public function getHasFollowedBack(): ?bool
    {
        return $this->hasFollowedBack;
    }

    public function setHasFollowedBack(?bool $hasFollowedBack): self
    {
        $this->hasFollowedBack = $hasFollowedBack;

        return $this;
    }
}
