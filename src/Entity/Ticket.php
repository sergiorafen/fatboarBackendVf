<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use function Symfony\Component\String\u;


/**
 * @ApiResource(
 *          normalizationContext={"groups"={"read:ticket"}},
 *          collectionOperations={
 *                                  "get"={
 *                                              "security"="is_granted('EDIT_TICKET',object)",
 *                                              "normalization_context"={"groups"={"read:ticket"}}},
*                                   "post"={
*                                               "security"="is_granted('IS_AUTHENTICATED_FULLY')",
*                                               "controller"=App\Controller\TicketCreateController::class,
*                                               "denormalization_context"={"groups"="create:ticket"}
*                                               
*                                           }
*                                 },
 * 
 *          itemOperations={
 *                  "get"={
 *                           "normalization_context"={"groups"={"read:ticket"}}},
 *                  "put"={
 *                          "security"="is_granted('EDIT_TICKET',object)",
 *                         "denormalization_context"={"groups"="create:ticket"}},
 *                  "delete"={"security"="is_granted('EDIT_TICKET',object)"
 *                              }
 *                      }
 * )
 * @ORM\Entity(repositoryClass=TicketRepository::class)
 */
class Ticket
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"create:ticket","read:ticket"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"create:ticket","read:ticket"})
     */
    private $numoticket;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"read:ticket","create:ticket"})
     */
    private $datepublished;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"read:ticket","create:ticket"})
     */
    private $totalprice;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:ticket","create:ticket"})
     */
    private $etat;

      /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="ticketuser")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read:ticket","create:ticket"})
     */
    private $user;

    /**
     *@var Ticket
     * @ORM\ManyToOne(targetEntity="Lot",inversedBy="ticketL")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read:ticket","create:ticket"})
     */
    private $ticketlot;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumoticket(): ?int
    {
        return $this->numoticket;
    }

    public function setNumoticket(?int $numoticket): self
    {
        $this->numoticket = $numoticket;

        return $this;
    }
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDatepublished(): ?\DateTimeInterface
    {
        return $this->datepublished;
    }

    public function setDatepublished(?\DateTimeInterface $datepublished): self
    {
        $this->datepublished = $datepublished;

        return $this;
    }

    public function getTotalprice(): ?int
    {
        return $this->totalprice;
    }

    public function setTotalprice(?int $totalprice): self
    {
        $this->totalprice = $totalprice;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getTicketlot(): ?Lot
    {
        return $this->ticketlot;
    }

    public function setTicketlot(?Lot $ticketlot): self
    {
        $this->ticketlot = $ticketlot;

        return $this;
    }
}
