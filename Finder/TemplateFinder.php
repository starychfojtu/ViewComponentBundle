<?php

declare(strict_types=1);

/*
 * This file is part of the `starychfojtu/viewcomponent` project.
 *
 * (c) https://github.com/starychfojtu/ViewComponentBundle/graphs/contributors
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace ViewComponent\Finder;

use Symfony\Component\Finder\Finder;
use ViewComponent\Exception\ComponentNotFoundException;
use ViewComponent\Exception\TemplateNotFoundException;

class TemplateFinder
{
    public const TEMPLATES_DIR = __DIR__ . '/../../../../templates/';
    public const CONFIG_TEMPLATES_DIRS = 'template_dirs';
    /**
     * @var array
     */
    private $configuredTemplateDirs;

    /**
     * TemplateFinder constructor.
     * @param array $configuredTemplateDirs
     */
    public function __construct(array $configuredTemplateDirs)
    {
        $this->configuredTemplateDirs = $configuredTemplateDirs;
    }

    /**
     * @param string $name
     * @return null|string
     * @throws TemplateNotFoundException
     */
    public function findTemplate(string $name): ?string
    {
        $templateDirs = $this->getTemplateDirs();

        for ($i = 0; $i < count($templateDirs); $i++) {
            $template = $this->findTemplateInDir($name, $templateDirs[$i]);

            if ($template != null) {
                return $this->configuredTemplateDirs[$i] . '/' . $template;
            }
        }

        throw new TemplateNotFoundException(
            ComponentNotFoundException::getErrorMessage($name, $templateDirs)
        );
    }

    /**
     * @return array
     */
    public function getTemplateDirs(): array
    {
        $func = function ($dir) {
            return self::TEMPLATES_DIR . $dir;
        };

        return array_map($func, $this->configuredTemplateDirs);
    }

    /**
     * @param string $name
     * @param string $dir
     * @return null|string
     */
    public function findTemplateInDir(string $name, string $dir): ?string
    {
        $finder = new Finder();
        $finder->files()->in($dir);

        foreach ($finder as $file) {
            $templateName = $file->getRelativePathname();
            if ($templateName == $name . '.html.twig') {
                return $file->getRelativePathname();
            }
        }

        return null;
    }
}