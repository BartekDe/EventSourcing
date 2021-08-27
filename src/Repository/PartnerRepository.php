<?php

namespace App\Repository;

use App\Repository\Aggregate\PartnerAggregateRepository;
use App\Repository\Doctrine\PartnerDoctrineRepository;

class PartnerRepository
{

    private PartnerAggregateRepository $aggregateRepository;
    private PartnerDoctrineRepository $doctrineRepository;

    /**
     * @param PartnerAggregateRepository $aggregateRepository
     * @param PartnerDoctrineRepository $doctrineRepository
     */
    public function __construct(
        PartnerAggregateRepository $aggregateRepository,
        PartnerDoctrineRepository $doctrineRepository
    )
    {
        $this->aggregateRepository = $aggregateRepository;
        $this->doctrineRepository = $doctrineRepository;
    }

    public function save()
    {

    }

}