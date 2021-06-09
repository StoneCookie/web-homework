<?php

declare(strict_types=1);

namespace App\Api\Goods\Factory;


use App\Api\Goods\Dto\GoodsResponseDto;
use App\Api\Goods\Dto\UserResponseDto;
use App\Core\Goods\Document\Goods;
use App\Core\Goods\Document\User;
use Symfony\Component\HttpFoundation\Response;

class ResponseFactory
{
    /**
     * @param Goods     $goods
     *
     * @param User|null $user
     *
     * @return GoodsResponseDto
     */
    public function createGoodsResponse(Goods $goods, ?User $user = null): GoodsResponseDto
    {
        $dto = new GoodsResponseDto();

        $dto->id              = $goods->getId();
        $dto->title           = $goods->getTitle();
        $dto->description     = $goods->getDescription();
        $dto->img             = $goods->getImg();
        $dto->cost            = $goods->getCost();
        $dto->dateOfPlacement = $goods->getDateOfPlacement();
        $dto->category        = $goods->getCategory();
        $dto->subcategory     = $goods->getSubcategory();
        $dto->city            = $goods->getCity();
        $dto->userData        = $goods->getUserData();
        $dto->check           = $goods->getCheck();

        if($user){
            $userResponseDto              = new UserResponseDto();
            $userResponseDto->id          = $user->getId();
            $userResponseDto->firstName   = $user->getFirstName();
            $userResponseDto->lastName    = $user->getLastName();
            $userResponseDto->age         = $user->getAge();
            $userResponseDto->phone       = $user->getPhone();
            $userResponseDto->email       = $user->getEmail();
            $userResponseDto->dateOfBirth = $user->getDateOfBirth();
            $userResponseDto->regDate     = $user->getRegDate();
            $userResponseDto->cityUser    = $user->getCityUser();
            $userResponseDto->rating      = $user->getRating();
            $userResponseDto->status      = $user->getStatus();
            $userResponseDto->roles       = $user->getRoles();

            $dto->user = $userResponseDto;
        }

        return $dto;
    }
}