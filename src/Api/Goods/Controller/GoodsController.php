<?php

declare(strict_types=1);

namespace App\Api\Goods\Controller;

use App\Api\Goods\Dto\GoodsCreateRequestDto;
use App\Api\Goods\Dto\GoodsListResponseDto;
use App\Api\Goods\Dto\GoodsResponseDto;
use App\Api\Goods\Dto\GoodsUpdateRequestDto;
use App\Api\Goods\Dto\UserResponseDto;
use App\Api\Goods\Dto\ValidationExampleRequestDto;
use App\Core\Common\Dto\ValidationFailedResponse;
use App\Core\Goods\Document\Goods;
use App\Core\Goods\Document\User;
use App\Core\Goods\Enum\Permission;
use App\Core\Goods\Enum\Role;
use App\Core\Goods\Enum\RoleHumanReadable;
use App\Core\Goods\Repository\UserRepository;
use App\Core\Goods\Repository\GoodsRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @Route("/goods")
 */
class GoodsController extends AbstractController
{
    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"GET"})
     *
     * @IsGranted(Permission::GOODS_SHOW)
     *
     * @ParamConverter("goods")
     *
     * @Rest\View()
     *
     * @param Goods|null $goods
     *
     * @return GoodsResponseDto
     */
    public function show(Goods $goods = null, UserRepository $userRepository)
    {
        if (!$goods) {
            throw $this->createNotFoundException('Item not found');
        }

        $user = $userRepository->findOneBy(['status' => $goods->getCheck()]);

        return $this->createGoodsResponse($goods, $user);
    }

    /**
     * @Route(path="", methods={"GET"})
     * @IsGranted(Permission::GOODS_INDEX)
     * @Rest\View()
     *
     * @return GoodsListResponseDto|ValidationFailedResponse
     */
    public function index(
        Request $request,
        GoodsRepository $goodsRepository
    ): GoodsListResponseDto {
        $page     = (int)$request->get('page');
        $quantity = (int)$request->get('slice');

        $items    = $goodsRepository->findBy([], [], $quantity, $quantity * ($page - 1));

        return new GoodsListResponseDto(
            ... array_map(
                    function (Goods $goods) {
                        return $this->createGoodsResponse($goods, null);
                    },
                    $items
                )
        );
    }

    /**
     * @Route(path="", methods={"POST"})
     * @IsGranted(Permission::GOODS_CREATE)
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View(statusCode=201)
     *
     * @param GoodsCreateRequestDto            $requestDto
     * @param ConstraintViolationListInterface $validationErrors
     * @param GoodsRepository                  $goodsRepository
     *
     * @return GoodsResponseDto|ValidationFailedResponse|Response
     */
    public function create(
        GoodsCreateRequestDto            $requestDto,
        ConstraintViolationListInterface $validationErrors,
        GoodsRepository                  $goodsRepository
    ) {
        if ($validationErrors->count() > 0) {
            return new ValidationFailedResponse($validationErrors);
        }

        if ($goods = $goodsRepository->findOneBy(['title' => $requestDto->title])) {
            return new Response('Item already exists', Response::HTTP_BAD_REQUEST);
        }

        $goods = new Goods(
            $requestDto->title,
            $requestDto->description,
            $requestDto->img,
            $requestDto->cost,
            $requestDto->dateOfPlacement,
            $requestDto->category,
            $requestDto->subcategory,
            $requestDto->city,
            $requestDto->userData,
            $requestDto->check,
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

        $goodsRepository->save($goods);

        return $this->creategoodsResponse($goods, null);
    }

    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"PUT"})
     * @IsGranted(Permission::GOODS_UPDATE)
     * @ParamConverter("user")
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View()
     *
     * @param GoodsUpdateRequestDto            $requestDto
     * @param ConstraintViolationListInterface $validationErrors
     * @param GoodsRepository                  $goodsRepository
     *
     * @return GoodsResponseDto|ValidationFailedResponse|Response
     */
    public function update(
        Goods $goods = null,
        GoodsUpdateRequestDto            $requestDto,
        ConstraintViolationListInterface $validationErrors,
        GoodsRepository                  $goodsRepository
    ) {
        if (!$goods) {
            throw $this->createNotFoundException('Item not found');
        }

        if ($validationErrors->count() > 0) {
            return new ValidationFailedResponse($validationErrors);
        }

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
        $goodsRepository->save($goods);

        return $this->createGoodsResponse($goods, null);
    }

    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"DELETE"})
     * @IsGranted(Permission::GOODS_DELETE)
     * @ParamConverter("user")
     *
     * @Rest\View()
     *
     * @param Goods|null      $goods
     * @param GoodsRepository $goodsRepository
     *
     * @return GoodsResponseDto|ValidationFailedResponse
     */
    public function delete(
        GoodsRepository $goodsRepository,
        Goods           $goods = null
    ) {
        if (!$goods) {
            throw $this->createNotFoundException('Item not found');
        }

        $goodsRepository->remove($goods);
    }

    /**
     * @Route(path="/validation", methods={"POST"})
     * @IsGranted(Permission::GOODS_VALIDATION)
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View()
     *
     * @return ValidationExampleRequestDto|ValidationFailedResponse
     */
    public function validation(
        ValidationExampleRequestDto      $requestDto,
        ConstraintViolationListInterface $validationErrors
    ) {
        if ($validationErrors->count() > 0) {
            return new ValidationFailedResponse($validationErrors);
        }

        return $requestDto;
    }

    /**
     * @param Goods $goods
     *
     * @param User|null $user
     *
     * @return GoodsResponseDto
     */
    private function createGoodsResponse(Goods $goods, ?User $user): GoodsResponseDto
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
