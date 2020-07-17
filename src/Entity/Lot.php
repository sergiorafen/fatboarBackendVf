<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use function Symfony\Component\String\u;

/**
 * @ApiResource(
 *          normalizationContext={"groups"={"read:ticket"}},
 *          collectionOperations={"get"={"normalization_context"={"groups"={"read:ticket"}}}
 *                              ,"post"={"denormalization_context"={"groups"="create:ticket"}}},
 *          itemOperations={"get"={"normalization_context"={"groups"={"read:ticket"}}}}
 * )
 * @ORM\Entity(repositoryClass=LotRepository::class)
 */

class Lot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"create:ticket","read:ticket"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"create:ticket","read:ticket"})
     */
    private $libelletlot;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"create:ticket","read:ticket"})
     */
    private $imgurl;

    /**
     *@var Ticket[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="Ticket", mappedBy="ticketlot")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read:ticket","create:ticket"})
     */
    private $ticketL;

    public function __construct()
    {
        $this->ticketL = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelletlot(): ?string
    {
        return $this->libelletlot;
    }

    public function setLibelletlot(string $libelletlot): self
    {
        $this->libelletlot = $libelletlot;

        return $this;
    }

    public function getImgurl(): ?string
    {
        return $this->imgurl;
    }

    public function setImgurl(string $imgurl): self
    {
        $this->imgurl = $imgurl;

        return $this;
    }

    /**
     * @return Collection|Ticket[]
     */
    public function getTicket(): Collection
    {
        return $this->ticketL;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->ticketL->contains($ticket)) {
            $this->ticket[] = $ticket;
            $ticket->setUser($this);
        }
        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->ticketL->contains($ticket)) {
            $this->ticketL->removeElement($ticket);
            // set the owning side to null (unless already changed)
            if ($ticket->getUser() === $this) {
                $ticket->setUser(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|Ticket[]
     */
    public function getTicketL(): Collection
    {
        return $this->ticketL;
    }

    public function addTicketL(Ticket $ticketL): self
    {
        if (!$this->ticketL->contains($ticketL)) {
            $this->ticketL[] = $ticketL;
            $ticketL->setTicketlot($this);
        }

        return $this;
    }

    public function removeTicketL(Ticket $ticketL): self
    {
        if ($this->ticketL->contains($ticketL)) {
            $this->ticketL->removeElement($ticketL);
            // set the owning side to null (unless already changed)
            if ($ticketL->getTicketlot() === $this) {
                $ticketL->setTicketlot(null);
            }
        }

        return $this;
    }
}
