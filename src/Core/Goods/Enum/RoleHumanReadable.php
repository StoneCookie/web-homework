<?php

declare(strict_types=1);

namespace App\Core\Goods\Enum;

use App\Core\Common\Enum\AbstractEnum;

final class RoleHumanReadable extends AbstractEnum
{
    public const OWNER = 'Владелец';
    public const VIP  = 'Вип пользователь';
    public const USER  = 'Пользователь';
}
