<?php

namespace App\Event\Partner;

use Prooph\EventSourcing\AggregateChanged;

class PartnerWasCreated extends AggregateChanged
{

    public function name(): string
    {
        return $this->payload['name'];
    }

    public function description(): string
    {
        return $this->payload['description'];
    }

    public function nip(): string
    {
        return $this->payload['nip'];
    }

    public function webpage(): ?string
    {
        return $this->payload['webpage'];
    }

}