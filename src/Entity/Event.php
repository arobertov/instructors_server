<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EventRepository;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"event:read"}},
 *     denormalizationContext={"groups"={"event:write"}},
 *     collectionOperations={
 *           "get",
 *           "post"={"security"="is_granted('ROLE_EDITOR')","security_message"="Нямате необходимите права да публикувате."}
 *     },
 *     itemOperations={
 *          "get"={"security"="is_granted('IS_AUTHENTICATED_ANONYMOUSLY')"},
 *          "put"={"security"="is_granted('EDIT',object)","security_message"="Нямате необходимите права да редактирате ."},
 *          "patch"={"security"="is_granted('EDIT',object)","security_message"="Нямате необходимите права да редактирате."},
 *          "delete"={"security"="is_granted('DELETE',object)","security_message"="Нямате необходимите права да изтривате."}
 *     }
 * )
 * @ApiFilter(OrderFilter::class,properties={"dateEdited":"DESC"})
 * @ORM\Table(name="events")
 * @ORM\Entity(repositoryClass=EventRepository::class)
 * @ORM\EntityListeners({"App\Listener\TrainEventListener"})
 */
class Event
{
    /**
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"event:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\Length(
     *      min = 3,
     *      minMessage = "Title name must be at least {{ limit }} characters long",
     * )
     * @Groups({"event:read","event:write"})
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Groups({"event:read","event:write"})
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"event:read","event:write"})
     */
    private ?\DateTimeInterface $dateCreated;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"event:read","event:write"})
     */
    private \DateTimeInterface $dateEdited;

    /**
     * @ORM\ManyToMany(targetEntity=Image::class, mappedBy="events")
     * @Groups({"event:read","event:write"})
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity=Train::class, inversedBy="events")
     * @Groups({"event:read","event:write"})
     */
    private $train;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"event:read","event:write"})
     */
    private $owner;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"event:read","event:write"})
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, mappedBy="events")
     * @Groups({"event:read","event:write"})
     */
    private $tags;

    /**
     * @ORM\ManyToMany(targetEntity=TrainFault::class, mappedBy="events")
     * @Groups({"event:read","event:write"})
     */
    private $trainFaults;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->trainFaults = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->addEvent($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            $image->removeEvent($this);
        }

        return $this;
    }

    public function getTrain(): ?Train
    {
        return $this->train;
    }

    public function setTrain(?Train $train): self
    {
        $this->train = $train;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?UserInterface $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addEvent($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeEvent($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, TrainFault>
     */
    public function getTrainFaults(): Collection
    {
        return $this->trainFaults;
    }

    public function addTrainFault(TrainFault $trainFault): self
    {
        if (!$this->trainFaults->contains($trainFault)) {
            $this->trainFaults[] = $trainFault;
            $trainFault->addEvent($this);
        }

        return $this;
    }

    public function removeTrainFault(TrainFault $trainFault): self
    {
        if ($this->trainFaults->removeElement($trainFault)) {
            $trainFault->removeEvent($this);
        }

        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    /**
     * @param \DateTimeInterface $dateCreated
     * @return self
     */
    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @param \DateTimeInterface $dateEdited
     * @return self
     */
    public function setDateEdited(\DateTimeInterface $dateEdited): self
    {
        $this->dateEdited = $dateEdited;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDateEdited(): ?\DateTimeInterface
    {
        return $this->dateEdited;
    }
}
