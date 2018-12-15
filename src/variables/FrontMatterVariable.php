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
    public function parse($template)
    {
        return FrontMatter::$plugin->frontMatter->parseTemplate($template)->getYAML();
    }

    public function source($template)
    {
        return FrontMatter::$plugin->frontMatter->parseTemplate($template)->getContent();
    }
}