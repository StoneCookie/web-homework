<?php

declare(strict_types=1);

namespace App\Api\Goods\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class GoodsUpdateRequestDto
{
    /**
     * @Assert\Length(max=50)
     */
    public ?string $title = null;

    /**
     * @Assert\Length(max=1000)
     */
    public ?string $description = null;

    public ?array $img = [];

    /**
     * @Assert\Length(max=15)
     */
    public ?int $cost = null;

    /**
     * @Assert\Length(max=10)
     * @Assert\Date()
     */
    public ?string $dateOfPlacement = null;

    /**
     * @Assert\Length(max=25)
     */
    public ?string $category = null;

    /**
     * @Assert\Length(max=25)
     */
    public ?string $subcategory = null;

    /**
     * @Assert\Length(max=20)
     */
    public ?string $city = null;

    public ?array $userData = [];

    /**
     * @Assert\Length(max=20)
     */
    public ?string $check = null;
}
