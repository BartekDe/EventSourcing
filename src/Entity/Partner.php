<?php

namespace App\Entity;

use App\Event\Partner\PartnerDescriptionChanged;
use App\Event\Partner\PartnerNameChanged;
use App\Event\Partner\PartnerWasCreated;
use App\Repository\Doctrine\PartnerDoctrineRepository;
use Doctrine\ORM\Mapping as ORM;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PartnerRepository::class)
 */
class Partner extends AggregateRoot
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private UuidInterface $uuid;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $description;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private string $nip;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $webpage;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTime $creationTime = null;

    /**
     * @ORM\Column(type="integer")
     */
    protected $version;

    public static function createNew(
        string  $name,
        string  $description,
        string  $nip,
        ?string $webpage = null
    ): Partner
    {
        $uuid = Uuid::uuid4();

        $instance = new self();
        $instance->creationTime = new \DateTime();

        $instance->recordThat(PartnerWasCreated::occur(
            $uuid->toString(),
            [
                'name' => $name,
                'description' => $description,
                'nip' => $nip,
                'webpage' => $webpage
            ]
        ));

        return $instance;
    }

    public function changeName(string $newName)
    {
        if ($this->name != $newName) {
            $this->recordThat(PartnerNameChanged::occur(
                $this->uuid->toString(),
                [
                    'newName' => $newName,
                    'oldName' => $this->name
                ]
            ));
        }
    }

    public function changeDescription(string $newDescription)
    {
        if ($this->description != $newDescription) {
            $this->recordThat(PartnerDescriptionChanged::occur(
                $this->uuid->toString(),
                [
                    'newDescription' => $newDescription,
                    'oldDescription' => $this->description
                ]
            ));
        }
    }

    protected function aggregateId(): string
    {
        return $this->uuid->toString();
    }

    protected function apply(AggregateChanged $event): void
    {
        switch (get_class($event)) {
            case PartnerWasCreated::class:
                $this->uuid = Uuid::fromString($event->aggregateId());
                $this->name = $event->name();
                $this->description = $event->description();
                $this->nip = $event->nip();
                $this->webpage = $event->webpage();
                break;
            case PartnerNameChanged::class:
                $this->name = $event->newName();
                break;
            case PartnerDescriptionChanged::class:
                $this->description = $event->newDescription();
                break;
            default:
                throw new \RuntimeException(sprintf('Unknown event type %s', get_class($event)));
        }
    }

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

}
