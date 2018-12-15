<?php
/**
 * @link https://www.github.com/tinydots/craft-front-matter
 * @copyright Copyright (c) Mike Pepper
 * @license MIT
 */
namespace tinydots\frontmatter\services;

use craft\base\Component;
use craft\web\twig\TemplateLoaderException;
use Mni\FrontYAML\Document;
use Mni\FrontYAML\Parser;

class FrontMatterService extends Component
{
    /** @var Parser The FrontYAML parser instance */
    protected $_parser;

    /** @var array */
    protected $_cache;

    public function init()
    {
        parent::init();

        $this->_parser = new Parser(null, null, '{#---', '---#}');
    }

    public function getParser()
    {
        return $this->_parser;
    }

    public function parseString(string $string): Document
    {
        $key = md5($string);
        if (!isset($this->_cache[$key])) {
            $this->_cache[$key] = $this->getParser()->parse($string, false);
        }

        return $this->_cache[$key];
    }

    /**
     * @param $templatePath
     * @return Document
     * @throws TemplateLoaderException
     */
    public function parseTemplate($templatePath): Document
    {
        $path = $this->_resolveTemplate($templatePath);

        $contents = file_get_contents($path);

        return $this->parseString($contents);
    }

    // Private Methods
    // =========================================================================

    /**
     * Returns the path to a given template, or throws a TemplateLoaderException.
     *
     * @param string $name
     * @return string
     * @throws TemplateLoaderException if the template doesn’t exist
     */
    private function _resolveTemplate(string $name)
    {
        $template = \Craft::$app->getView()->resolveTemplate($name);

        if ($template !== false) {
            return $template;
        }

        throw new TemplateLoaderException($name, \Craft::t('app', 'Unable to find the template “{template}”.', ['template' => $name]));
    }
}