<?php

/**
 *
 * @package yii2-simple-dual-listbox
 * @author Edwin Artunduaga <edwinhaq@gmail.com>
 * @copyright Copyright &copy; Edwin Artunduaga, 2017
 * @version 1.0.0
 */
namespace edwinhaq\simpleduallistbox;

use yii\widgets\InputWidget;
use yii\base\InvalidParamException;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * SimpleDualListbox widget.
 *
 * @see https://github.com/edwinhaq/yii2-simple-dual-listbox
 * @since 1.0.0
 */
class SimpleDualListbox extends InputWidget
{
	/**
	 *
	 * @var array None selected items, private use
	 */
	private $items_nosel = [ ];

	/**
	 *
	 * @var string HTML element id, private use
	 */
	private $id;

	/**
	 *
	 * @var array Widget items
	 */
	public $items = [ ];

	/**
	 *
	 * @var array Selected items in widget
	 */
	public $selection = [ ];

	/**
	 *
	 * @var array HTML attributes for the widget
	 */
	public $options = [ ];

	/**
	 *
	 * @var array options for javascript functions
	 */
	public $clientOptions = [ ];

	/**
	 *
	 * @var string Label for input widget
	 */
	public $label;

	/**
	 *
	 * @var string Hint to show for input widget
	 */
	public $hint;

	/**
	 *
	 * @var boolean if true widget wraps element in <div class='form-group'> ... </div>
	 */
	public $useGroupDiv = true;

	/**
	 *
	 * @var string if useGroupDiv is set to true, groupDivId sets id for wrapping div
	 */
	public $groupDivId = '';

	/**
	 *
	 * @var string template for Widget HTML elements
	 */
	public $template = '{label}{listbox}{hint}';

	/**
	 *
	 * @param array $all All the items
	 * @param array $sel Selected items
	 * @return array Items separated (selected and none selected)
	 */
	private function extractSelection($all = [], $sel = [])
	{
		$list = [
			'noselected' => [ ],
			'selected' => [ ]
		];
		foreach ( $all as $id_all_item => $val_all_item )
		{
			$tmp = true;
			foreach ( $sel as $id_sel_item )
			{
				if ($id_all_item == $id_sel_item)
				{
					$tmp = false;
					break;
				}
			}
			if ($tmp)
				$list ['noselected'] [$id_all_item] = $val_all_item;
			else
				$list ['selected'] [$id_all_item] = $val_all_item;
		}
		return $list;
	}

	/**
	 * Update each item with title attribute if is set in options settings
	 *
	 * @param array $itemlist
	 */
	private function updateListboxOptionTitles($itemlist)
	{
		if (! isset ( $this->options ['options'] ))
		{
			$this->options ['options'] = [ ];
		}

		foreach ( $itemlist as $k => $v )
		{
			if (isset ( $this->options ['options'] [$k] ['title'] ))
			{
			} else
			{
				$this->options ['options'] [$k] ['title'] = $v;
			}
		}
	}

	/**
	 *
	 * {@inheritdoc}
	 * @see \yii\base\Widget::run()
	 */
	public function run()
	{
		if (! is_array ( $this->items ))
		{
			throw new InvalidParamException ( 'Parameter items must be an array.' );
		}

		if (! is_array ( $this->options ))
		{
			throw new InvalidParamException ( 'Parameter options must be an array.' );
		}

		if (! is_array ( $this->clientOptions ))
		{
			throw new InvalidParamException ( 'Parameter clientOptions must be an array.' );
		}

		Html::addCssClass ( $this->options, 'form-control' );
		$this->options ['multiple'] = true;

		if ($this->hasModel ())
		{

			if (! isset ( $this->model->{$this->attribute} ))
			{
				throw new InvalidParamException ( "Attribute $this->attribute not exists." );
			}

			$this->id = (array_key_exists ( 'id', $this->options )) ? $this->options ['id'] : Html::getInputId ( $this->model, $this->attribute );

			$list = $this->extractSelection ( $this->items, $this->model->{$this->attribute} );

			$this->updateListboxOptionTitles ( $list ['selected'] );

			$element = Html::activeListBox ( $this->model, $this->attribute, $list ['selected'], $this->options );
		} else
		{
			if (! is_array ( $this->selection ))
			{
				throw new InvalidParamException ( 'Parameter clientOptions must be an array.' );
			}

			$this->id = (array_key_exists ( 'id', $this->options )) ? $this->options ['id'] : uniqid ( 'simple_dual_listbox_' );

			$list = $this->extractSelection ( $this->items, $this->selection );

			$this->updateListboxOptionTitles ( $list ['selected'] );

			$label = '';
			if ($this->label)
			{
				$label = Html::label ( $this->label, $this->name, [
					'class' => 'control-label'
				] );
			}

			$hint = '';
			if ($this->hint)
			{
				$hint = Html::tag ( 'div', $this->hint, [
					'class' => 'hint-block'
				] );
			}

			$listbox = Html::listBox ( $this->name, $this->selection, $list ['selected'], $this->options );
			/*
			 * $content .= Html::tag('div', '', [
			 * 'class' => 'help-block'
			 * ]);
			 */
			$content = $this->template;
			$content = str_replace ( '{label}', $label, $content );
			$content = str_replace ( '{listbox}', $listbox, $content );
			$content = str_replace ( '{hint}', $hint, $content );

			if ($this->useGroupDiv)
			{
				$element = Html::tag ( 'div', $content, [
					'class' => 'form-group',
					'id' => $this->groupDivId
				] );
			} else
			{
				$element = $content;
			}
		}
		$this->items_nosel = $list ['noselected'];

		$this->registerClientScript ();

		return $element;
	}

	/**
	 * Registers the required JavaScript.
	 */
	public function registerClientScript()
	{
		$view = $this->getView ();
		SimpleDualListboxAsset::register ( $view );
		$options = Json::encode ( empty ( $this->clientOptions ) ? [ ] : $this->clientOptions );
		$data = Json::encode ( $this->items_nosel );
		$view->registerJs ( "$('#$this->id').listboxdual($options, $data);" );
	}
}
