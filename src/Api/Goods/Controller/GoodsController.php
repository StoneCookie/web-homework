<?php

declare(strict_types=1);

namespace App\Api\Goods\Controller;

use App\Api\Goods\Dto\GoodsCreateRequestDto;
use App\Api\Goods\Dto\GoodsListResponseDto;
use App\Api\Goods\Dto\GoodsResponseDto;
use App\Api\Goods\Dto\GoodsUpdateRequestDto;
use App\Api\Goods\Dto\UserResponseDto;
use App\Api\Goods\Dto\ValidationExampleRequestDto;
use App\Api\Goods\Factory\ResponseFactory;
use App\Core\Common\Dto\ValidationFailedResponse;
use App\Core\Common\Factory\HTTPResponseFactory;
use App\Core\Goods\Document\Goods;
use App\Core\Goods\Document\User;
use App\Core\Goods\Enum\Permission;
use App\Core\Goods\Enum\Role;
use App\Core\Goods\Enum\RoleHumanReadable;
use App\Core\Goods\Repository\UserRepository;
use App\Core\Goods\Repository\GoodsRepository;
use App\Core\Goods\Service\GoodsService;
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
     * @param Goods|null      $goods
     * @param ResponseFactory $responseFactory
     *
     * @return GoodsResponseDto
     */
    public function show(
        Goods           $goods = null,
        UserRepository  $userRepository,
        ResponseFactory $responseFactory
    )
    {
        if (!$goods) {
            throw $this->createNotFoundException('Item not found');
        }

        $user = $userRepository->findOneBy(['status' => $goods->getCheck()]);

        return $responseFactory->createGoodsResponse($goods, $user);
    }

    /**
     * @Route(path="", methods={"GET"})
     * @IsGranted(Permission::GOODS_INDEX)
     * @Rest\View()
     *
     * @param Request         $request
     * @param GoodsRepository $goodsRepository
     * @param ResponseFactory $responseFactory
     *
     * @return GoodsListResponseDto|ValidationFailedResponse
     */
    public function index(
        Request         $request,
        GoodsRepository $goodsRepository,
        ResponseFactory $responseFactory
    ): GoodsListResponseDto {
        $page     = (int)$request->get('page');
        $quantity = (int)$request->get('slice');

        $items    = $goodsRepository->findBy([], [], $quantity, $quantity * ($page - 1));

        return new GoodsListResponseDto(
            ... array_map(
                    function (Goods $goods) use ($responseFactory) {
                        return $responseFactory->createGoodsResponse($goods, null);
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
     * @param GoodsService                     $service
     * @param ResponseFactory                  $responseFactory
     * @param HTTPResponseFactory              $HTTPResponseFactory
     * @return GoodsResponseDto|Response
     */
    public function create(
        GoodsCreateRequestDto            $requestDto,
        ConstraintViolationListInterface $validationErrors,
        GoodsService                     $service,
        ResponseFactory                  $responseFactory,
        HTTPResponseFactory              $HTTPResponseFactory
    ) {
        if ($validationErrors->count() > 0) {
            return $HTTPResponseFactory->createValidationFailedResponse($validationErrors);
        }

        return $responseFactory->createGoodsResponse($service->createGoods($requestDto));
    }

    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"PUT"})
     * @IsGranted(Permission::GOODS_UPDATE)
     * @ParamConverter("user")
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View()
     *
     * @param Goods|null                       $goods
     * @param GoodsUpdateRequestDto            $requestDto
     * @param ConstraintViolationListInterface $validationErrors
     * @param GoodsService                     $service
     * @param ResponseFactory                  $responseFactory
     *
     * @return GoodsResponseDto|ValidationFailedResponse|Response
     */
    public function update(
        Goods                            $goods = null,
        GoodsUpdateRequestDto            $requestDto,
        ConstraintViolationListInterface $validationErrors,
        GoodsService                     $service,
        ResponseFactory                  $responseFactory
    ) {
        if (!$goods) {
            throw $this->createNotFoundException('Item not found');
        }

        if ($validationErrors->count() > 0) {
            return new ValidationFailedResponse($validationErrors);
        }

        return $responseFactory->createGoodsResponse($service->updateGoods($goods, $requestDto));
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
}
