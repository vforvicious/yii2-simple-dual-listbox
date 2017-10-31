<?php

/**
 * @package   yii2-simple-dual-listbox
 * @author    Edwin Artunduaga <edwinhaq@gmail.com>
 * @copyright Copyright &copy; Edwin Artunduaga, 2017
 * @version   1.0.0
 */
namespace edwinhaq\simpleduallistbox;

use yii\web\AssetBundle;

/**
 * Asset bundle for SimpleDualListbox widget.
 *
 * @author Edwin Artunduaga <edwinhaq@gmail.com>
 * @since 1.0.0
 */
class SimpleDualListboxAsset extends AssetBundle
{
	/**
	 * @inheritdoc
	 */
	public $depends = [
		'yii\web\JqueryAsset',
		'yii\bootstrap\BootstrapAsset'
	];

	/**
	 *
	 * {@inheritDoc}
	 * @see \yii\web\AssetBundle::init()
	 */
	public function init()
	{
		$this->sourcePath = __DIR__ . '/assets';
		$this->css = [
				YII_DEBUG ? 'css/simple-dual-listbox.css' : 'css/simple-dual-listbox.min.css'
		];
		$this->js = [
				YII_DEBUG ? 'js/simple-dual-listbox.js' : 'js/simple-dual-listbox.min.js'
		];
		parent::init();
	}
}
