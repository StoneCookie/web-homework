<?php

declare(strict_types=1);

namespace App\Core\Goods\Enum;

use App\Core\Common\Enum\AbstractEnum;

class UserStatus extends AbstractEnum
{
    public const ACTIVE   = 'active';
    public const INACTIVE = 'inactive';
}
