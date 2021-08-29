<?php

namespace App\Event\Partner;

use Prooph\EventSourcing\AggregateChanged;

class PartnerWebpageChanged extends AggregateChanged
{

    public function newWebpage(): ?string
    {
        return $this->payload()['newWebpage'];
    }

    public function oldWebpage(): ?string
    {
        return $this->payload()['oldWebpage'];
    }

}