<?php

namespace App\Util;

use App\Dto\PartnerDto;
use App\Entity\Partner;
use Doctrine\ORM\EntityManagerInterface;

class PartnerService
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createAndSavePartner(PartnerDto $partnerDto): Partner
    {
        $partner = Partner::createNew(
            $partnerDto->name,
            $partnerDto->description,
            $partnerDto->nip,
            $partnerDto->webpage
        );

        $this->save($partner);

        return $partner;
    }

    private function save(Partner $partner)
    {
        $this->entityManager->persist($partner);
        $this->entityManager->flush();
    }

}