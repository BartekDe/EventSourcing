<?php

namespace App\Event\Partner;

use Prooph\EventSourcing\AggregateChanged;

class PartnerNipChanged extends AggregateChanged
{

    public function newNip(): string
    {
        return $this->payload()['newNip'];
    }

    public function oldNip(): string
    {
        return $this->payload()['oldNip'];
    }

}