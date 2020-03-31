<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContentTypeRepository")
 */
class ContentType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Alternative", mappedBy="contentType")
     */
    private $alternatives;

    public function __construct()
    {
        $this->alternatives = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
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

    /**
     * @return Alternative[]|Collection
     */
    public function getAlternatives(): Collection
    {
        return $this->alternatives;
    }

    public function addAlternative(Alternative $alternative): self
    {
        if (!$this->alternatives->contains($alternative)) {
            $this->alternatives[] = $alternative;
            $alternative->setContentType($this);
        }

        return $this;
    }

    public function removeAlternative(Alternative $alternative): self
    {
        if ($this->alternatives->contains($alternative)) {
            $this->alternatives->removeElement($alternative);
            // set the owning side to null (unless already changed)
            if ($alternative->getContentType() === $this) {
                $alternative->setContentType(null);
            }
        }

        return $this;
    }
}
