<?php

/**
 * @package   yii2-simple-dual-listbox
 * @author    Edwin Artunduaga <edwinhaq@gmail.com>
 * @copyright Copyright &copy; Edwin Artunduaga, 2017
 * @version   1.0.0
 */
namespace edwinhaq\simpleduallistbox;

use Yii;
use yii\web\AssetBundle;

/**
 * Asset bundle for SimpleDualListbox widget.
 *
 * @see https://github.com/edwinhaq/yii2-listbox-dual
 * @author Edwin Artunduaga <edwinhaq@gmail.com>
 * @since 1.0
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
	 * @inheritdoc
	 */
	public function init()
	{
		$this->sourcePath = __DIR__ . '/assets';
		
		$this->css = [
			'css/simple-dual-listbox.css' 
		];
		$this->js = [
			'js/simple-dual-listbox.js' 
		];
		parent::init();
	}
}
