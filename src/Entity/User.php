<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true, nullable=false)
     */
    private $email;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", nullable=false)
     */
    private $password;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $isActive;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $auth;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ability", mappedBy="user", orphanRemoval=true)
     */
    private $abilities;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Knowledge", mappedBy="user")
     */
    private $knowledge;

    private $plainPassword;

    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
        $this->isActive = 1;
        $this->auth = 1000;

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getIsActive():? int
    {
        return $this->isActive;
    }
    
    public function setIsActive(int $isActive): self
    {
        $this->isActive = $isActive;
        
        return $this;
    }

    public function getAuth():? int
    {
        return $this->auth;
    }
    
    public function setAuth(int $auth): self
    {
        $this->auth = $auth;
        
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return $this->roles;
        
        // $roles = explode(",", $this->roles);
        // // guarantee every user at least has ROLE_USER
        // $roles[] = 'ROLE_USER';

        // return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = implode(",", $roles);

        return $this;
    }
    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPlainPassword(): string
    {
        return (string) $this->plainPassword;
    }

    public function setPlainPassword(string $password): self
    {
        $this->plainPassword = $password;

        return $this;
    }

    /**
     * @return Collection|Ability[]
     */
    public function getAbilities(): Collection
    {
        return $this->abilities;
    }

    public function addAbility(Ability $ability): self
    {
        if (!$this->abilities->contains($ability)) {
            $this->abilities[] = $ability;
            $ability->setUser($this);
        }

        return $this;
    }

    public function removeAbility(Ability $ability): self
    {
        if ($this->abilities->contains($ability)) {
            $this->abilities->removeElement($ability);
            // set the owning side to null (unless already changed)
            if ($ability->getUser() === $this) {
                $ability->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Knowledge[]
     */
    public function getKnowledge(): Collection
    {
        return $this->knowledge;
    }

    public function addKnowledge(Knowledge $knowledge): self
    {
        if (!$this->knowledge->contains($knowledge)) {
            $this->knowledge[] = $knowledge;
            $knowledge->setUser($this);
        }

        return $this;
    }

    public function removeKnowledge(Knowledge $knowledge): self
    {
        if ($this->knowledge->contains($knowledge)) {
            $this->knowledge->removeElement($knowledge);
            // set the owning side to null (unless already changed)
            if ($knowledge->getUser() === $this) {
                $knowledge->setUser(null);
            }
        }

        return $this;
    }
}
