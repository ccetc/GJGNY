<?php

namespace GJGNY\ChildBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class GJGNYChildBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}