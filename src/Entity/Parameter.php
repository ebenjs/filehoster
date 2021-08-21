<?php

namespace App\Entity;

use App\Repository\ParameterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParameterRepository::class)
 */
class Parameter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $firstUse;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstUse(): ?bool
    {
        return $this->firstUse;
    }

    public function setFirstUse(bool $firstUse): self
    {
        $this->firstUse = $firstUse;

        return $this;
    }
}
