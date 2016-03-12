<?php

namespace AppBundle\Services;

interface RegistrationNumberCreator
{
    /**
     * Generate a unique Registration Number. This should be ~ 34 chars long and unique for each call.
     *
     * @return string
     */
    public function getUniqueRegistrationNumber();
}