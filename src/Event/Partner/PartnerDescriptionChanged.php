<?php

namespace App\Event\Partner;

use Prooph\EventSourcing\AggregateChanged;

class PartnerDescriptionChanged extends AggregateChanged
{

    public function newDescription(): string
    {
        return $this->payload()['newDescription'];
    }

    public function oldDescription(): string
    {
        return $this->payload()['oldDescription'];
    }

}