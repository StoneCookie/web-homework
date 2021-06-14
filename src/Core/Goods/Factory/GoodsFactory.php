<?php

declare(strict_types=1);

namespace App\Core\Goods\Factory;

use App\Core\Goods\Document\Goods;

class GoodsFactory
{
    public function create
    (
        string $title,
        string $description,
        array  $img,
        int    $cost,
        string $dateOfPlacement,
        string $category,
        string $subcategory,
        string $city,
        array  $userData,
        string $check
    ): Goods
    {
        return new Goods(
            $title,
            $description,
            $img,
            $cost,
            $dateOfPlacement,
            $category,
            $subcategory,
            $city,
            $userData,
            $check
        );
    }

    public function update
    (
        string $title,
        string $description,
        array  $img,
        int    $cost,
        string $dateOfPlacement,
        string $category,
        string $subcategory,
        string $city,
        array  $userData,
        string $check
    ): Goods
    {
        return new Goods(
            $title,
            $description,
            $img,
            $cost,
            $dateOfPlacement,
            $category,
            $subcategory,
            $city,
            $userData,
            $check
        );
    }
}