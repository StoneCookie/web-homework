<?php

declare(strict_types=1);

namespace App\Core\Goods\Enum;

use App\Core\Common\Enum\AbstractEnum;

class Role extends AbstractEnum
{
    public const OWNER  = 'ROLE_OWNER';
    public const VIP  = 'ROLE_VIP';
    public const USER  = 'ROLE_USER';
}
