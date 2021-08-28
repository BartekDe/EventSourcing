<?php

namespace App\Event\Partner;

use Prooph\EventSourcing\AggregateChanged;

class PartnerNameChanged extends AggregateChanged
{

    public function newName(): string
    {
        return $this->payload()['newName'];
    }

    public function oldName(): string
    {
        return $this->payload()['oldName'];
    }

}