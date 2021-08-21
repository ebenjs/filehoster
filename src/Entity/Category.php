<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=FileToUpload::class, mappedBy="category", orphanRemoval=true)
     */
    private $fileToUploads;

    public function __construct()
    {
        $this->fileToUploads = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection|FileToUpload[]
     */
    public function getFileToUploads(): Collection
    {
        return $this->fileToUploads;
    }

    public function addFileToUpload(FileToUpload $fileToUpload): self
    {
        if (!$this->fileToUploads->contains($fileToUpload)) {
            $this->fileToUploads[] = $fileToUpload;
            $fileToUpload->setCategory($this);
        }

        return $this;
    }

    public function removeFileToUpload(FileToUpload $fileToUpload): self
    {
        if ($this->fileToUploads->removeElement($fileToUpload)) {
            // set the owning side to null (unless already changed)
            if ($fileToUpload->getCategory() === $this) {
                $fileToUpload->setCategory(null);
            }
        }

        return $this;
    }
}
