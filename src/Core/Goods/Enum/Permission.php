<?php

declare(strict_types=1);

namespace App\Core\Goods\Enum;

use App\Core\Common\Enum\AbstractEnum;

class Permission extends AbstractEnum
{
    public const GOODS_SHOW       = 'ROLE_GOODS_SHOW';
    public const GOODS_INDEX      = 'ROLE_GOODS_INDEX';
    public const GOODS_CREATE     = 'ROLE_GOODS_CREATE';
    public const GOODS_UPDATE     = 'ROLE_GOODS_UPDATE';
    public const GOODS_DELETE     = 'ROLE_GOODS_DELETE';
    public const GOODS_VALIDATION = 'ROLE_GOODS_VALIDATION';
}
