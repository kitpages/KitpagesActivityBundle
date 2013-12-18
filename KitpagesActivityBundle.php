<?php

namespace Kitpages\ActivityBundle;

use Kitpages\ActivityBundle\DependencyInjection\Compiler\ObjectAdapterCompilerPass;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;


class KitpagesActivityBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }
}
