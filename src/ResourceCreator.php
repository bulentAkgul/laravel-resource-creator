<?php

namespace Bakgul\ResourceCreator;

use Bakgul\Kernel\Helpers\Settings;

class ResourceCreator
{
    public function isStandalone($key = '')
    {
        return Settings::standalone($key);
    }
}