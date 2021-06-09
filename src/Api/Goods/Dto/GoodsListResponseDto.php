<?php

declare(strict_types=1);

namespace App\Api\Goods\Dto;

class GoodsListResponseDto
{
    public array $data;

    public function __construct(GoodsResponseDto ... $data)
    {
        $this->data = $data;
    }
}
