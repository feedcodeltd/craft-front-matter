<?php
namespace tinydots\frontmatter\tests\unit\services;

use Codeception\Test\Unit;
use Mni\FrontYAML\Parser;
use tinydots\frontmatter\FrontMatter;
use tinydots\frontmatter\services\FrontMatterService;

class FrontMatterServiceTest extends Unit
{
    /** @var FrontMatterService */
    private $service;

    private $template = <<<TWIG
{#---
key: value
---#}

<p>contents</p>
TWIG;

    protected function _before()
    {
        $this->service = FrontMatter::$plugin->frontMatter;
    }

    public function testParserExists()
    {
        $this->assertInstanceOf(Parser::class, $this->service->getParser());
    }

    public function testExtractsDataFromString()
    {
        $expected = [
            'key' => 'value'
        ];

        $parsed = $this->service->parseString($this->template);

        $this->assertEquals($expected, $parsed->getYAML());
    }

    public function testExtractsSourceFromString()
    {
        $expected = '<p>contents</p>';
        $parsed = $this->service->parseString($this->template);

        $this->assertEquals($expected, $parsed->getContent());
    }
}