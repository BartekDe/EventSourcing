<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class PartnerDto
{

    /**
     * @Assert\NotBlank
     * @Assert\Length(max = 64)
     */
    public string $name;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max = 255)
     */
    public string $description;

    /**
     * @Assert\NotBlank
     * @Assert\Length(10)
     */
    public string $nip;

    /**
     * @Assert\NotBlank(allowNull = true)
     * @Assert\Length(max = 255)
     */
    public string $webpage;

}