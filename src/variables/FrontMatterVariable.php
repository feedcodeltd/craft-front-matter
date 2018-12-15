<?php
/**
 * @link https://www.github.com/tinydots/craft-front-matter
 * @copyright Copyright (c) Mike Pepper
 * @license MIT
 */
namespace tinydots\frontmatter\variables;

use tinydots\frontmatter\FrontMatter;

/**
 * Class FrontMatterVariable
 *
 * @author Mike Pepper <mdcpepper@gmail.com>
 * @since 1.0.0
 */
class FrontMatterVariable
{
    /**
     * @param $template
     * @return mixed
     * @throws \craft\web\twig\TemplateLoaderException
     */
    public function parse($template)
    {
        return FrontMatter::$plugin->frontMatter->parseTemplate($template)->getYAML();
    }

    /**
     * @param $template
     * @return string
     * @throws \craft\web\twig\TemplateLoaderException
     */
    public function source($template): string
    {
        return FrontMatter::$plugin->frontMatter->parseTemplate($template)->getContent();
    }
}