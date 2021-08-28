<?php

namespace App\Repository\Aggregate;

use App\Dto\PartnerDto;
use App\Entity\Partner;
use Prooph\Common\Event\ProophActionEventEmitter;
use Prooph\Common\Messaging\FQCNMessageFactory;
use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Prooph\EventSourcing\EventStoreIntegration\ClosureAggregateTranslator;
use Prooph\EventStore\ActionEventEmitterEventStore;
use Prooph\EventStore\EventStore;
use Prooph\EventStore\Metadata\MetadataMatcher;
use Prooph\EventStore\Metadata\Operator;
use Prooph\EventStore\Pdo\PersistenceStrategy\PostgresSingleStreamStrategy;
use Prooph\EventStore\Pdo\PostgresEventStore;
use Prooph\EventStore\StreamName;

class PartnerAggregateRepository extends AggregateRepository
{

    protected $eventStore;

    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;

        parent::__construct(
            $eventStore,
            AggregateType::fromAggregateRootClass('App\Entity\Partner'),
            new ClosureAggregateTranslator()
        );
    }

    public function save(Partner $partner): void
    {
        $this->saveAggregateRoot($partner);
    }

    public function getEvents(string $uuid): array
    {
        $eventsIterator = $this->eventStore->load(
            $this->determineStreamName($uuid),
            1,
            null,
            $this->matchByMetadata($uuid)
        );

        $events = [];
        foreach ($eventsIterator as $event) {
            $events[] = $event;
        }
        return $events;
    }

    private function matchByMetadata(string $uuid): MetadataMatcher
    {
        $metadataMatcher = new MetadataMatcher();
        $metadataMatcher = $metadataMatcher->withMetadataMatch(
            '_aggregate_id',
            Operator::EQUALS(),
            $uuid
        );
        return $metadataMatcher;
    }

}