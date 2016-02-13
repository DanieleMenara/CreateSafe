<?php
namespace UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CreateSafeUserBundle extends Bundle
{
    public function getParent() {
        return 'FOSUserBundle';
    }
}