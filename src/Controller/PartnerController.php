<?php

namespace App\Controller;

use App\Dto\PartnerDto;
use App\Entity\Partner;
use App\Form\PartnerType;
use App\Util\JsonUtil;
use App\Util\PartnerService;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use JMS\Serializer\Serializer;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

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