<?php declare(strict_types=1);


namespace App\Constant;


final class DateTimeFormat
{
    // valid ICU Datetime Pattern (see http://userguide.icu-project.org/formatparse/datetime)
    public const NORMAL = 'Y-MM-dd HH:mm:ss';
    public const NORMAL_TZ = 'Y-MM-dd HH:mm Z';

    // standard php format
    public const FORMAT = 'Y-m-d H:i:s';

}
