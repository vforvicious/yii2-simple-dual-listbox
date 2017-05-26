<?php

/**
 * @package   yii2-listbox-dual
 * @author    Edwin Artunduaga <edwinhaq@gmail.com>
 * @copyright Copyright &copy; Edwin Artunduaga, 2017
 * @version   1.0.0
 */
namespace edwinhaq\listboxdual;

use Yii;
use yii\web\AssetBundle;

/**
 * Asset bundle for ListboxDual widget.
 *
 * @see https://github.com/edwinhaq/yii2-listbox-dual
 * @author Edwin Artunduaga <edwinhaq@gmail.com>
 * @since 1.0
 */
class ListboxDualAsset extends AssetBundle
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
			'css/listbox-dual.css' 
		];
		$this->js = [
			'js/listbox-dual.js' 
		];
		parent::init();
	}
}
