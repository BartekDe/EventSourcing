<?php

namespace App\Util;

use App\Dto\PartnerDto;
use App\Entity\Partner;
use App\Repository\Aggregate\PartnerAggregateRepository;
use App\Repository\PartnerRepository;
use Doctrine\ORM\EntityManagerInterface;

class PartnerService
{

    private PartnerRepository $partnerRepository;

    public function __construct(
        PartnerRepository $partnerRepository
    )
    {
        $this->partnerRepository = $partnerRepository;
    }

    public function createAndSavePartner(PartnerDto $partnerDto): Partner
    {
        $partner = Partner::createNew(
            $partnerDto->name,
            $partnerDto->description,
            $partnerDto->nip,
            $partnerDto->webpage
        );

        $this->partnerRepository->save($partner);

        return $partner;
    }

    public function updatePartner(Partner $partner, PartnerDto $partnerDto)
    {
        $partner->changeName($partnerDto->name);
    }

}