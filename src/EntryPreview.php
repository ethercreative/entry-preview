<?php
/**
 * Entry Preview plugin for Craft CMS 3.x
 *
 * .
 *
 * @link      https://ethercreative.co.uk
 * @copyright Copyright (c) 2018 Ether Creative
 */

namespace ether\entrypreview;


use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\events\RegisterUrlRulesEvent;

use yii\base\Event;

/**
 * Class EntryPreview
 *
 * @author    Ether Creative
 * @package   EntryPreview
 * @since     1.0.0
 *
 */
class EntryPreview extends Plugin
{
	// Static Properties
	// =========================================================================

	/**
	 * @var EntryPreview
	 */
	public static $plugin;

	// Public Properties
	// =========================================================================

	/**
	 * @var string
	 */
	public $schemaVersion = '1.0.0';

	// Public Methods
	// =========================================================================

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();
		self::$plugin = $this;

		Event::on(
			UrlManager::class,
			UrlManager::EVENT_REGISTER_SITE_URL_RULES,
			function (RegisterUrlRulesEvent $event) {
				$event->rules['siteActionTrigger1'] = 'entry-preview/share';
			}
		);

		Craft::info(
			Craft::t(
				'entry-preview',
				'{name} plugin loaded',
				['name' => $this->name]
			),
			__METHOD__
		);
	}
}
