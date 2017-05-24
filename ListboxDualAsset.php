<?php

/**
 * @package   yii2-listbox-dual
 * @author    Edwin Artunduaga <edwinhaq@gmail.com>
 * @copyright Copyright &copy; Edwin Artunduaga, 2017
 * @version   1.0.0
 */

namespace edwinhaq\listboxdual;

use Yii;
use kartik\base\AssetBundle;

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
	public function init()
	{
		$this->setSourcePath(__DIR__ . '/assets');
		$this->setupAssets('css', ['css/listbox-dual']);
		$this->setupAssets('js', ['js/listbox-dual']);
		parent::init();
	}
}
