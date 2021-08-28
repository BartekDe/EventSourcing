<?php

namespace App\Controller;

use App\Dto\PartnerDto;
use App\Form\PartnerType;
use App\Repository\Doctrine\PartnerDoctrineRepository;
use App\Util\JsonUtil;
use App\Util\PartnerService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class PartnerController extends AbstractFOSRestController
{

    private JsonUtil $jsonUtil;

    public function __construct(JsonUtil $jsonUtil)
    {
        $this->jsonUtil = $jsonUtil;
    }

    /**
     * @Rest\Post("/partner")
     */
    public function createPartnerAction(Request $request, PartnerService $partnerService): Response
    {
        $partnerDto = new PartnerDto();

        $form = $this->createForm(PartnerType::class, $partnerDto);
        $form->submit($this->jsonUtil->getJson($request));

        if ($form->isValid()) {
            $partner = $partnerService->createAndSavePartner($partnerDto);
            return $this->handleView($this->view($partner, Response::HTTP_OK));
        } else {
            return $this->handleErrors($form);
        }
    }

    /**
     * @Rest\Get("/partner")
     */
    public function getPartnersAction(PartnerDoctrineRepository $partnerRepository): Response
    {
        $partners = $partnerRepository->findAll();
        return $this->handleView($this->view($partners, Response::HTTP_OK));
    }

    /**
     * @Rest\Put("/partner/{uuid}")
     */
    public function updatePartnerAction(
        string $uuid,
        Request $request,
        PartnerDoctrineRepository $partnerRepository,
        PartnerService $partnerService
    ): Response
    {
        $partner = $partnerRepository->find($uuid);

        if (empty($partner)) {
            return $this->handleView($this->view(
                'Partner with id ' . $uuid . 'does not exist',
                Response::HTTP_NOT_FOUND
            ));
        }

        $partnerDto = new PartnerDto();

        $form = $this->createForm(PartnerType::class, $partnerDto);
        $form->submit($this->jsonUtil->getJson($request));

        $partnerService->updatePartner($partner, $partnerDto);

        return $this->handleView($this->view($partner, Response::HTTP_OK));

    }

    private function handleErrors(FormInterface $form): Response
    {
        $errors = [];
        foreach ($form->getErrors(true, true) as $error) {
            $errors[] = $error->getCause();
        }

        return $this->handleView(
            $this->view(
                $this->handleErrors($form),
                Response::HTTP_BAD_REQUEST
            )
        );
    }

}