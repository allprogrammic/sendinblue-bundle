<?php

/*
 * This file is part of the AllProgrammic SendinBlueBundle package.
 *
 * (c) AllProgrammic SAS <contact@allprogrammic.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AllProgrammic\Bundle\SendinBlueBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $nodeBuilder = $treeBuilder->root('sendinblue')->addDefaultsIfNotSet()->children();

        $nodeBuilder
            ->arrayNode('api')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('key')->isRequired()->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}