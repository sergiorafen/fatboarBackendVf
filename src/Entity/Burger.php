<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BurgerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     paginationItemsPerPage=2,
 *     normalizationContext={"groups"={"read:comment"}},
 *     collectionOperations={
 *       "get"={"security"="is_granted('ROLE_ADMIN')"},
 *       "post"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "denormalization_context"={"groups"={"create:comment"}}
 *       }
 *     },
 *     itemOperations={
 *      "get"={
 *          "normalization_context"={"groups"={"read:comment", "read:full:comment"}}
 *       },
 *       "put"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "denormalization_context"={"groups"={"update:comment"}}
 *       },
 *       "delete"={
 *          "security"="is_granted('ROLE_ADMIN')"
 *       }
 *     }
 * )
 * @ORM\Entity(repositoryClass=BurgerRepository::class)
 */
class Burger
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageurl;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImageurl(): ?string
    {
        return $this->imageurl;
    }

    public function setImageurl(?string $imageurl): self
    {
        $this->imageurl = $imageurl;

        return $this;
    }
}
