<?php

namespace App\Entity;

use App\Manager\ManageableEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package App\Entity
 * @author Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements ManageableEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $instagramId;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $followedOn;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    private $hasFollowedBack;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $likesGiven;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $likesReceived;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getInstagramId(): ?int
    {
        return $this->instagramId;
    }

    /**
     * @param int $instagramId
     * @return User
     */
    public function setInstagramId(int $instagramId): self
    {
        $this->instagramId = $instagramId;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getFollowedOn(): ?\DateTimeInterface
    {
        return $this->followedOn;
    }

    /**
     * @param \DateTimeInterface $followedOn
     * @return User
     */
    public function setFollowedOn(\DateTimeInterface $followedOn): self
    {
        $this->followedOn = $followedOn;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getHasFollowedBack(): ?bool
    {
        return $this->hasFollowedBack;
    }

    /**
     * @param bool|null $hasFollowedBack
     * @return User
     */
    public function setHasFollowedBack(?bool $hasFollowedBack): self
    {
        $this->hasFollowedBack = $hasFollowedBack;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getLikesGiven(): ?int
    {
        return $this->likesGiven;
    }

    /**
     * @param int $likesGiven
     * @return User
     */
    public function setLikesGiven(int $likesGiven): self
    {
        $this->likesGiven = $likesGiven;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getLikesReceived(): ?int
    {
        return $this->likesReceived;
    }

    /**
     * @param int $likesReceived
     * @return User
     */
    public function setLikesReceived(int $likesReceived): self
    {
        $this->likesReceived = $likesReceived;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return join(', ', array(
                $this->instagramId,
                $this->followedOn->format('Y-m-d H:i:s'),
                $this->hasFollowedBack)
        );
    }
}
