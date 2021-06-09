<?php

declare(strict_types=1);

namespace App\Core\Goods\Service;

use App\Api\Goods\Dto\GoodsCreateRequestDto;
use App\Core\Goods\Document\Goods;
use App\Core\Goods\Factory\GoodsFactory;
use App\Core\Goods\Repository\GoodsRepository;
use Psr\Log\LoggerInterface;

class GoodsService
{
    /**
     * @var GoodsRepository
     */
    private GoodsRepository $goodsRepository;
    /**
     * @var GoodsFactory
     */
    private GoodsFactory $goodsFactory;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    public function __construct
    (
        LoggerInterface $logger,
        GoodsRepository $goodsRepository,
        GoodsFactory    $goodsFactory
    )
    {
        $this->goodsRepository = $goodsRepository;
        $this->goodsFactory    = $goodsFactory;
        $this->logger          = $logger;
    }

    public function createGoods(GoodsCreateRequestDto $requestDto): Goods
    {
        $goods = $this->goodsFactory->create
        (
            $requestDto->title,
            $requestDto->description,
            $requestDto->img,
            $requestDto->cost,
            $requestDto->dateOfPlacement,
            $requestDto->category,
            $requestDto->subcategory,
            $requestDto->city,
            $requestDto->userData,
            $requestDto->check
        );

        $goods->setTitle($requestDto->title);
        $goods->setDescription($requestDto->description);
        $goods->setImg($requestDto->img);
        $goods->setCost($requestDto->cost);
        $goods->setDateOfPlacement($requestDto->dateOfPlacement);
        $goods->setCategory($requestDto->category);
        $goods->setSubcategory($requestDto->subcategory);
        $goods->setCity($requestDto->city);
        $goods->setUserData($requestDto->userData);
        $goods->setCheck($requestDto->check);

        $goods = $this->goodsRepository->save($goods);

        $this->logger->info('Item created successfully', [
            'id' => $goods->getId()
        ]);

        return $goods;
    }
}