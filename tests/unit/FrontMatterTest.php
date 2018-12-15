<?php
namespace tinydots\frontmatter;

use Codeception\Test\Unit;
use craft\web\twig\variables\CraftVariable;
use tinydots\frontmatter\services\FrontMatterService;
use tinydots\frontmatter\variables\FrontMatterVariable;

class FrontMatterTest extends Unit
{
    private $plugin;

    protected function _before()
    {
        $this->plugin = new FrontMatter('front-matter');
    }

    public function testHasAStaticAttributeThatIsAnInstanceOfThePlugin()
    {
        $this->assertClassHasStaticAttribute('plugin', FrontMatter::class);
    }


    public function testSetsTheFrontMatterServiceComponent()
    {
        $this->assertInstanceOf(FrontMatterService::class, $this->plugin::$plugin->frontMatter);
    }

    public function testSetsTheFrontMatterVariable()
    {
        $this->assertInstanceOf(FrontMatterVariable::class, (new CraftVariable())->frontMatter);
    }
}