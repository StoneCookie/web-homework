<?php

declare(strict_types=1);

namespace App\Core\Goods\Repository;

use App\Core\Common\Repository\AbstractRepository;
use App\Core\Goods\Document\Goods;
use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;

/**
 * @method Goods      save(Goods $goods)
 * @method Goods|null find(string $id)
 * @method Goods|null findOneBy(array $criteria)
 * @method Goods      getOne(string $id)
 */
class GoodsRepository extends AbstractRepository
{
    public function getDocumentClassName(): string
    {
        return Goods::class;
    }

    /**
     * @throws LockException
     * @throws MappingException
     */
    public function getGoodsById(string $id): ?Goods
    {
        return $this->find($id);
    }
}
