<?php

namespace App\Repository;

use App\Dto\PartnerDto;
use App\Entity\Partner;
use App\Repository\Aggregate\PartnerAggregateRepository;
use App\Repository\Doctrine\PartnerDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

class PartnerRepository
{

    private PartnerAggregateRepository $aggregateRepository;
    private PartnerDoctrineRepository $doctrineRepository;
    private EntityManagerInterface $entityManager;

    /**
     * @param PartnerAggregateRepository $aggregateRepository
     * @param PartnerDoctrineRepository $doctrineRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        PartnerAggregateRepository $aggregateRepository,
        PartnerDoctrineRepository $doctrineRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->aggregateRepository = $aggregateRepository;
        $this->doctrineRepository = $doctrineRepository;
        $this->entityManager = $entityManager;
    }

    public function save(Partner $partner)
    {
        $this->aggregateRepository->saveAggregateRoot($partner);
        $this->saveEntity($partner);
    }

    private function saveEntity(Partner $partner)
    {
        $this->entityManager->persist($partner);
        $this->entityManager->flush();
    }

    public function update(Partner $partner, PartnerDto $partnerDto)
    {
        $this->entityManager->flush();
        $this->aggregateRepository->saveAggregateRoot($partner);
    }

}