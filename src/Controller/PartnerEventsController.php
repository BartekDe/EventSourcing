<?php

namespace App\Controller;

use App\Dto\PartnerDto;
use App\Form\PartnerType;
use App\Repository\Doctrine\PartnerDoctrineRepository;
use App\Util\JsonUtil;
use App\Util\PartnerService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class PartnerEventsController extends AbstractFOSRestController
{

    /**
     * @Rest\Get("/events/partner/{uuid}")
     */
    public function getPartnerEventsAction(
        string $uuid,
        PartnerService $partnerService,
        Request $request
    ): Response
    {
        $events = $partnerService->getPartnerEvents($uuid);
        return $this->handleView($this->view($events, Response::HTTP_OK));
    }

}