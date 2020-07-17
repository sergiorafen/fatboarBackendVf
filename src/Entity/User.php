<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ApiResource(
 *          normalizationContext={"groups"={"read:ticket"}},
 *          collectionOperations={"get"={},"post"={"denormalization_context"={"groups"="create:ticket"}}},
 *          itemOperations={"get"={"normalization_context"={"groups"={"read:ticket"}}}}
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity("email",message="Cette email est déjà utilisé")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"create:ticket","read:ticket"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\NotBlank
     * @Assert\Length(
      *      min = 2,
      *      minMessage = "Le nom doit avoir au minimum 2 lettres ?"
      * )
      * @Assert\Regex(
      *     pattern="/^[a-z\s+a-z+ÖØ-öø-ÿ]+$/i",
      *     message="Votre prénom ne doit pas comporter de chiffre et ni de symbole"
      * )
     * @Groups({"create:ticket","read:ticket"})
     */
    private $username;

      /**
     *@var Ticket[]|ArrayCollection
     * 
     *  @ORM\OneToMany(
     *                  targetEntity="Ticket",
     *                  mappedBy="user")
     */
    private $ticketuser;

    /**
     * @ORM\Column(type="string", length=255)
     *@Assert\NotBlank(message="Le password est obligatoire")
     */
    private $password;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     *@ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\NotBlank
     * @Assert\Length(
      *      min = 2,
      *      minMessage = "Le nom doit avoir au minimum 2 lettres ?"
      * )
      * @Assert\Regex(
      *     pattern="/^[a-z\s+a-z+ÖØ-öø-ÿ]+$/i",
      *     message="Votre prénom ne doit pas comporter de chiffre et ni de symbole"
      * )
     */
    private $nom;

    /**
    * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     *@Assert\Email(message = "The email '{{ value }}' is not a valid email.")
     *@Assert\NotBlank(message="L email est obligatoire")
     *@Groups({"create:ticket","read:ticket"})
     */
    private $email;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $cgvcgu;

    /**
     * @ORM\Column(type="boolean")
     */
    private $newsletter;

    /**
     * @ORM\Column(type="boolean")
     */
    private $majeur;


    public function __construct()
    {
        $this->isActive=true;
        $this->ticket = new ArrayCollection();
        $this->ticketuser = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }
    /**
     * @var array
     *
     * @ORM\Column(type="json")
     */
    private $roles = [];

    public function getRoles(): array
    {
        $roles = $this->roles;
        if(empty($roles)){
            $roles[]='ROLE_USER';
        }
        return array_unique($roles);
    }

    public function setRoles(array $roles):void{
        $this->roles=$roles;
    }

    public function eraseCredentials()
    {
        
    }

    public function getSalt()
    {
        return null;
    }

    /**
     * @return Collection|Ticket[]
     */
    public function getTicket(): Collection
    {
        return $this->ticket;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->ticket->contains($ticket)) {
            $this->ticket[] = $ticket;
            $ticket->setUser($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->ticket->contains($ticket)) {
            $this->ticket->removeElement($ticket);
            // set the owning side to null (unless already changed)
            if ($ticket->getUser() === $this) {
                $ticket->setUser(null);
            }
        }

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCgvcgu(): ?bool
    {
        return $this->cgvcgu;
    }

    public function setCgvcgu(?bool $cgvcgu): self
    {
        $this->cgvcgu = $cgvcgu;

        return $this;
    }

    public function getNewsletter(): ?bool
    {
        return $this->newsletter;
    }

    public function setNewsletter(bool $newsletter): self
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    public function getMajeur(): ?bool
    {
        return $this->majeur;
    }

    public function setMajeur(bool $majeur): self
    {
        $this->majeur = $majeur;

        return $this;
    }

    /**
     * @return Collection|Ticket[]
     */
    public function getTicketuser(): Collection
    {
        return $this->ticketuser;
    }

    public function addTicketuser(Ticket $ticketuser): self
    {
        if (!$this->ticketuser->contains($ticketuser)) {
            $this->ticketuser[] = $ticketuser;
            $ticketuser->setUser($this);
        }

        return $this;
    }

    public function removeTicketuser(Ticket $ticketuser): self
    {
        if ($this->ticketuser->contains($ticketuser)) {
            $this->ticketuser->removeElement($ticketuser);
            // set the owning side to null (unless already changed)
            if ($ticketuser->getUser() === $this) {
                $ticketuser->setUser(null);
            }
        }

        return $this;
    }
}
