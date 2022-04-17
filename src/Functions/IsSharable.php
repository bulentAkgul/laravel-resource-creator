<?php

namespace Bakgul\ResourceCreator\Functions;

use Bakgul\Kernel\Helpers\Settings;

class IsSharable
{
    public static function _($variation): bool
    {
        return in_array($variation, Settings::resourceOptions('levels.low'))
            && Settings::resourceOptions('share_low_levels_between_apps');
    }
}