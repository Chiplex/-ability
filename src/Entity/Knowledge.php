<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\KnowledgeRepository")
 */
class Knowledge
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *     min = 2,
     *     max = 10,
     *      minMessage = "Mensaje muy corto",
     *      maxMessage = "Mensaje muy largo"
     * )
     */
    private $mencion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="knowledge")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMencion(): ?string
    {
        return $this->mencion;
    }

    public function setMencion(string $mencion): self
    {
        $this->mencion = $mencion;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }
}
