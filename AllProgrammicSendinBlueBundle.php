<?php

namespace AllProgrammic\Bundle\SendinBlueBundle;

use AllProgrammic\Bundle\SendinBlueBundle\DependencyInjection\SendinblueExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AllProgrammicSendinBlueBundle extends Bundle
{
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new SendinblueExtension();
        }
        return $this->extension;
    }
}