<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Form\PartnerType;
use App\Util\JsonUtil;
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

    private $jsonUtil;
    private $entityManager;

    public function __construct(JsonUtil $jsonUtil, EntityManagerInterface $entityManager)
    {
        $this->jsonUtil = $jsonUtil;
        $this->entityManager = $entityManager;
    }

    /**
     * @Rest\Post("/partner")
     */
    public function createPartnerAction(Request $request): Response
    {
        $partner = new Partner();

        $form = $this->createForm(PartnerType::class, $partner);
        $form->submit($this->jsonUtil->getJson($request));

        if ($form->isValid()) {
            $this->entityManager->persist($partner);
            $this->entityManager->flush();
        } else {
            return $this->handleErrors($form);
        }

        return $this->handleView(
            $this->view($partner, Response::HTTP_OK)
        );
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