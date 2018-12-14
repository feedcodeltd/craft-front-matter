<?php
/**
 * @link https://www.github.com/tinydots/craft-front-matter
 * @copyright Copyright (c) Mike Pepper
 * @license MIT
 */

namespace tinydots\frontmatter;

use tinydots\frontmatter\services\FrontMatterService;
use tinydots\frontmatter\variables\FrontMatterVariable;
use craft\base\Plugin;
use craft\web\twig\variables\CraftVariable;
use yii\base\Event;

/**
 * Class FrontMatter
 *
 * @property FrontMatterService $frontMatter
 * @author Mike Pepper <mdcpepper@gmail.com>
 * @since 1.0.0
 */
class FrontMatter extends Plugin
{
    /** @var FrontMatter */
    public static $plugin;

    public function init()
    {
        parent::init();

        self::$plugin = $this;

        $this->setComponents([
            'frontMatter' => FrontMatterService::class,
        ]);

        Event::on(CraftVariable::class, CraftVariable::EVENT_INIT, function (Event $event) {
            $variable = $event->sender;
            $variable->set('frontMatter', FrontMatterVariable::class);
        });
    }
}