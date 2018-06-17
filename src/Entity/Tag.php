<?php

namespace App\Entity;

use App\Manager\ManageableEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Tag
 * @package App\Entity
 * @author Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 *
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 */
class Tag implements ManageableEntity
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
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $label;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return Tag
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->label;
    }
}
