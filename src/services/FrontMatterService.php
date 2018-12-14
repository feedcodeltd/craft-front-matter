<?php
/**
 * @link https://www.github.com/tinydots/craft-front-matter
 * @copyright Copyright (c) Mike Pepper
 * @license MIT
 */
namespace tinydots\frontmatter\services;

use Mni\FrontYAML\Parser;
use Craft;
use craft\base\Component;
use function file_get_contents;

/**
 * Class FrontMatterService
 *
 * @author Mike Pepper <mdcpepper@gmail.com>
 * @since 1.0.0
 */
class FrontMatterService extends Component
{
    /** @var Parser the front matter parser instance */
    protected $_parser;

    protected $_cache;

    public function init()
    {
        parent::init();

        $this->_parser = new Parser(null, null, '{#---', '---#}');
    }

    public function parse($template, $markdown = true): array
    {
        $yaml = $this->getParsed($template, $markdown)->getYAML();

        return $yaml ?: [];
    }

    public function source($template): string
    {
        return $this->getParsed($template, false)->getContent();
    }


    public function getParsed($template, $markdown = false): string
    {
        $key = md5($template . (string) $markdown);

        if (!isset($this->_cache[$key])) {
            $contents = $this->_getTemplateContents($template);
            $this->_cache[$key] = $this->_parser->parse($contents, $markdown);
        }

        return $this->_cache[$key];
    }

    private function _getTemplateContents($template): string
    {
        $path = Craft::$app->getView()->resolveTemplate($template);

        return $path ? file_get_contents($path) : '';
    }
}