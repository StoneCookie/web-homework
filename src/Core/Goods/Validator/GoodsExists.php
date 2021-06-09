<?php

declare(strict_types=1);

namespace App\Core\Goods\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class GoodsExists extends Constraint
{
    public $message = 'Item already exists, title: {{ title }}';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}