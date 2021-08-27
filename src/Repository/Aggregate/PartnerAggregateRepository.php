<?php

namespace App\Repository\Aggregate;

use App\Entity\Partner;
use Prooph\Common\Event\ProophActionEventEmitter;
use Prooph\Common\Messaging\FQCNMessageFactory;
use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Prooph\EventStore\ActionEventEmitterEventStore;
use Prooph\EventStore\Pdo\PersistenceStrategy\PostgresSingleStreamStrategy;
use Prooph\EventStore\Pdo\PostgresEventStore;

class PartnerAggregateRepository extends AggregateRepository
{

    public $eventStore;

    public function __construct()
    {
        // TODO: config prooph_pdo_event_store.yaml
        $eventStore = new ActionEventEmitterEventStore(
            new PostgresEventStore(
                new FQCNMessageFactory(),
                new \PDO('pgsql:host=localhost;port=5432;dbname=partner;user=postgres;password=postgres'),
                new PostgresSingleStreamStrategy()
            ),
            new ProophActionEventEmitter()
        );

        $this->eventStore = $eventStore;

        parent::__construct(
            $eventStore,
            AggregateType::fromAggregateRootClass('App\Entity\Partner'),
            new AggregateTranslator(),
            null,
            null,
            true
        );
    }

    public function save(Partner $partner): void
    {
        $this->saveAggregateRoot($partner);
    }

    public function get(string $uuid): object
    {
        return $this->getAggregateRoot($uuid);
    }

}