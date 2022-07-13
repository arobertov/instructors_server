<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TrainFaultRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"fault:read"}},
 *     denormalizationContext={"groups"={"fault:write"}},
 *     collectionOperations={
 *           "get",
 *           "post"={"security"="is_granted('ROLE_EDITOR')","security_message"="Нямате необходимите права публикувате."}
 *     },
 *     itemOperations={
 *          "get"={"security"="is_granted('IS_AUTHENTICATED_ANONYMOUSLY')"},
 *          "put"={"security"="is_granted('EDIT',object)","security_message"="Нямате необходимите права да редактирате ."},
 *          "patch"={"security"="is_granted('EDIT',object)","security_message"="Нямате необходимите права да редактирате."},
 *          "delete"={"security"="is_granted('DELETE',object)","security_message"="Нямате необходимите права да изтривате."}
 *     },
 *     attributes={"pagination_enabled"=false}
 *
 * )
 * @ORM\Table(name="trainFaults")
 * @ORM\Entity(repositoryClass=TrainFaultRepository::class)
 * @UniqueEntity(fields={"faultId"}, message="There is already an id with this fault")
 */
class TrainFault
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer",unique=true)
     * @Assert\NotBlank()
     * @Groups({"fault:read","event:read"})
     */
    private $faultId;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Groups({"fault:read"})
     */
    private $faultDescription;

    /**
     * @ORM\Column(type="text",nullable=true)
     * @Groups({"fault:read"})
     */
    private $shortAdvice;

    /**
     * @ORM\Column(type="text",nullable=true)
     * @Groups({"fault:read"})
     */
    private $longAdvice;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"fault:read"})
     */
    private $faultCategory;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, inversedBy="trainFaults")
     */
    private $events;

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFaultId(): ?int
    {
        return $this->faultId;
    }

    public function setFaultId(int $faultId): self
    {
        $this->faultId = $faultId;

        return $this;
    }

    public function getFaultDescription(): ?string
    {
        return $this->faultDescription;
    }

    public function setFaultDescription(string $faultDescription): self
    {
        $this->faultDescription = $faultDescription;

        return $this;
    }

    public function getShortAdvice(): ?string
    {
        return $this->shortAdvice;
    }

    public function setShortAdvice(string $shortAdvice): self
    {
        $this->shortAdvice = $shortAdvice;

        return $this;
    }

    public function getLongAdvice(): ?string
    {
        return $this->longAdvice;
    }

    public function setLongAdvice(string $longAdvice): self
    {
        $this->longAdvice = $longAdvice;

        return $this;
    }

    public function getFaultCategory(): ?string
    {
        return $this->faultCategory;
    }

    public function setFaultCategory(?string $faultCategory): self
    {
        $this->faultCategory = $faultCategory;

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        $this->events->removeElement($event);

        return $this;
    }
}
