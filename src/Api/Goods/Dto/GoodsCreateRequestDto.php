<?php

declare(strict_types=1);

namespace App\Api\Goods\Dto;

use App\Core\Goods\Validator\GoodsExists;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @GoodsExists()
 */
class GoodsCreateRequestDto
{
    /**
     * @Assert\Length(max=50)
     */
    public string $title;

    /**
     * @Assert\Length(max=1000)
     */
    public string $description;

    public ?array $img = [];

    /**
     * @Assert\Length(max=10)
     */
    public int $cost;

    /**
     * @Assert\Length(max=10)
     * @Assert\Date()
     */
    public string $dateOfPlacement;

    /**
     * @Assert\Length(max=30)
     */
    public string $category;

    /**
     * @Assert\Length(max=30)
     */
    public string $subcategory;

    /**
     * @Assert\Length(max=20)
     */
    public string $city;

    public ?array $userData;

    /**
     * @Assert\Length(max=15)
     */
    public string $check;

}
