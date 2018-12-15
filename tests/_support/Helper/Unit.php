<?php
namespace Helper;

use Codeception\TestCase;
use Codeception\Module;
use craft\web\View;
use tinydots\frontmatter\FrontMatter;
use Craft;
use craft\i18n\I18N;
use craft\console\Request;
use craft\console\Application;
use yii\console\Controller;

class Unit extends Module
{
    public function _before(TestCase $test)
    {
        $mockApp = $this->getMockApp($test);
        $mockApp->controller = $this->getMock($test, Controller::class);
        $mockApp->controller->module = $this->getMockModule($test);

        Craft::$app = $mockApp;
    }

    private function getMockModule(TestCase $test)
    {
        return $this->getMock($test, FrontMatter::class);
    }

    private function getMockApp(TestCase $test)
    {
        $mockApp = $this->getMock($test, Application::class);
        $mockRequest = $this->getMock($test, Request::class);

        $mockApp->expects($test->any())
            ->method('getRequest')
            ->willReturn($mockRequest);

        return $mockApp;
    }

    private function getMock(TestCase $test, string $class)
    {
        return $test->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}