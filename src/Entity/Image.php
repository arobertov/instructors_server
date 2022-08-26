<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use App\Controller\ImageController;

/**
 * @Vich\Uploadable()
 * @ApiResource(
 *     normalizationContext={"groups"={"image:read"}},
 *     denormalizationContext={"groups"={"image:write"}},
 *     collectionOperations={
 *      "get",
 *      "post"={
 *              "controller"=ImageController::class,
 *              "deserialize"=false,
 *              "security"="is_granted('ROLE_EDITOR')",
 *              "security_message"="Нямате необходимите права да качвате изображение.",
 *              "openapi_context"={
 *                 "requestBody"={
 *                     "content"={
 *                         "multipart/form-data"={
 *                             "schema"={
 *                                 "type"="object",
 *                                 "properties"={
 *                                     "fileImage"={
 *                                         "type"="string",
 *                                         "format"="binary"
 *                                     }
 *                                 }
 *                             }
 *                         }
 *                     }
 *                 }
 *             }
 *      }
 *     },
 *     itemOperations={
 *          "get"={"security"="is_granted('IS_AUTHENTICATED_ANONYMOUSLY')"},
 *          "delete"={"security"="is_granted('DELETE',object)","security_message"="Нямате необходимите права да изтривате изображение."}
 *     }
 * )
 * @ORM\Table(name="images")
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"image:read","event:read"})
     */
    public ?string $contentUrl;

    /**
     * @Vich\UploadableField(mapping="image", fileNameProperty="filePath")
     * @var File|null
     */
    public ?File $fileImage = null;


    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"image:read","image:write","event:read"})
     */
    private $filePath;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, inversedBy="images")
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

    public function getContentUrl(): ?string
    {
        return $this->contentUrl;
    }

    public function setContentUrl(string $contentUrl): self
    {
        $this->contentUrl = $contentUrl;

        return $this;
    }

    public function getFileImage(): ?File
    {
        return $this->fileImage;
    }

    /**
     * @param File|null $fileImage
     * @return $this
     */
    public function setFileImage(?File $fileImage = null): self
    {
        $this->fileImage = $fileImage;

        return $this;
    }


    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(string $filePath): self
    {
        $this->filePath = $filePath;

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