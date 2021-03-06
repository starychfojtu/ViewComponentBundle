<?php

/*
 * This file is part of the `starychfojtu/viewcomponent` project.
 *
 * (c) https://github.com/starychfojtu/ViewComponentBundle/graphs/contributors
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Starychfojtu\ViewComponentBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('starychfojtu_view_component');

        $rootNode
            ->children()
                ->arrayNode('component_dirs')
                    ->prototype('scalar')
                    ->end()
                ->end()
                ->arrayNode('template_dirs')
                    ->prototype('scalar')
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
