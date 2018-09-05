<?php
/**
 * Entry Preview plugin for Craft CMS 3.x
 *
 * .
 *
 * @link      https://ethercreative.co.uk
 * @copyright Copyright (c) 2018 Ether Creative
 */

namespace ether\entrypreview\controllers;

use ether\entrypreview\EntryPreview;

use Craft;
use craft\web\Controller;
use craft\helpers\UrlHelper;

/**
 * @author    Ether Creative
 * @package   EntryPreview
 * @since     1.0.0
 */
class ShareController extends Controller
{
	// Protected Properties
	// =========================================================================

	/**
	 * @var    bool|array Allows anonymous access to this controller's actions.
	 *         The actions must be in 'kebab-case'
	 * @access protected
	 */
	protected $allowAnonymous = ['index'];

	// Public Methods
	// =========================================================================

	/**
	 * @return mixed
	 */
	public function actionIndex()
	{
		$entryId = Craft::$app->getRequest()->getParam('entryId');
		$siteId = Craft::$app->getRequest()->getParam('siteId') ?? 1;

		$entry = Craft::$app->getEntries()->getEntryById($entryId, $siteId);

		if(!$entry)
			throw new NotFoundHttpException('Entry not found');

		$params = [
			'entryId' => $entryId,
			'siteId' => $siteId
		];

		$token = Craft::$app->getTokens()->createToken([
			'entries/view-shared-entry',
			$params
		]);

		if($token === false)
			throw new Exception('There was a problem generating the token.');

		$url = UrlHelper::urlWithToken($entry->getUrl(), $token);

		return Craft::$app->getResponse()->redirect($url);
	}
}
