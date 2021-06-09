<?php

declare(strict_types=1);

namespace App\Api\Goods\Dto;

class GoodsResponseDto
{
    public ?string $id;

    public ?string $title;

    public ?string $description;

    public ?array  $img;

    public ?int    $cost;

    public ?string $dateOfPlacement;

    public ?string $category;

    public ?string $subcategory;

    public ?string $city;

    public ?array  $userData;

    public ?string $check;

    public ?string $roleHumanReadable;

    public UserResponseDto $user;
}
