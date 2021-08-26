<?php

namespace App\Entity;

use App\Event\Partner\PartnerWasCreated;
use App\Repository\PartnerRepository;
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
     * @Assert\NotBlank
     * @Assert\Length(max = 64)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(max = 255)
     */
    private string $description;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank
     * @Assert\Length(10)
     */
    private string $nip;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(allowNull = true)
     * @Assert\Length(max = 255)
     */
    private ?string $webpage;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Assert\Type("\DateTimeImmutable")
     */
    private \DateTimeImmutable $creationTime;

    public static function createNew(
        string  $name,
        string  $description,
        string  $nip,
        ?string $webpage = null
    ): Partner
    {
        $uuid = Uuid::uuid4();

        $instance = new self();
        $instance->creationTime = new \DateTimeImmutable();

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
            default:
                throw new \RuntimeException(sprintf('Unknown event type %s', get_class($event)));
        }
    }
}
