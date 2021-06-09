<?php

declare(strict_types=1);

namespace App\Core\Goods\Validator;

use App\Core\Goods\Repository\GoodsRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class GoodsExistsValidator extends ConstraintValidator
{
    /**
     * @var GoodsRepository
     */
    private GoodsRepository $goodsRepository;

    public function __construct(GoodsRepository $goodsRepository)
    {
        $this->goodsRepository = $goodsRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof GoodsExists) {
            throw new UnexpectedTypeException($constraint, GoodsExists::class);
        }

        $goods = $this->goodsRepository->findOneBy(['title' => $value->title]);

        if($goods) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ title }}', $goods->getTitle())
                ->addViolation();
        }
    }
}
