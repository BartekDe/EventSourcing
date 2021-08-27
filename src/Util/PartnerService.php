<?php

namespace App\Util;

use App\Dto\PartnerDto;
use App\Entity\Partner;
use App\Repository\Aggregate\PartnerAggregateRepository;
use Doctrine\ORM\EntityManagerInterface;

class PartnerService
{

    private EntityManagerInterface $entityManager;
    private PartnerAggregateRepository $aggregateRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        PartnerAggregateRepository $aggregateRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->aggregateRepository = $aggregateRepository;
    }

    public function createAndSavePartner(PartnerDto $partnerDto): Partner
    {
        $partner = Partner::createNew(
            $partnerDto->name,
            $partnerDto->description,
            $partnerDto->nip,
            $partnerDto->webpage
        );
        dump($partner);

        $this->aggregateRepository->save($partner);
//        dump($partner);

//        $this->save($partner);

        return $partner;
    }

    private function save(Partner $partner)
    {
        $this->entityManager->persist($partner);
        $this->entityManager->flush();
    }

}