<?php

namespace edwinhaq\simpleduallistbox;

use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 *
 * @package yii2-simple-dual-listbox
 * @author Edwin Artunduaga <edwinhaq@gmail.com>
 * @copyright Copyright &copy; Edwin Artunduaga, 2017
 * @version 1.0.0
 */
class SimpleDualListbox extends InputWidget
{
	public $items = [];
	private $items_nosel = [];
	public $selection = [];
	public $options = [];
	public $clientOptions = [];
	public $label;
	public $hint;
	
	/**
	 *
	 * @param array $all        	
	 * @param array $sel        	
	 * @return unknown[]
	 */
	private function extractSelection($all = [], $sel = [])
	{
		$list = [];
		foreach($all as $id_all_item => $val_all_item)
		{
			$tmp = true;
			foreach($sel as $id_sel_item)
			{
				if ($id_all_item == $id_sel_item)
				{
					$tmp = false;
					break;
				}
			}
			if ($tmp)
				$list['noselected'][$id_all_item] = $val_all_item;
			else
				$list['selected'][$id_all_item] = $val_all_item;
		}
		return $list;
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \yii\base\Widget::run()
	 */
	public function run()
	{
		if (! is_array($this->items))
		{
			throw new InvalidParamException('Parameter items must be an array.');
		}
		
		if (! is_array($this->options))
		{
			throw new InvalidParamException('Parameter options must be an array.');
		}
		
		if (! is_array($this->clientOptions))
		{
			throw new InvalidParamException('Parameter clientOptions must be an array.');
		}
		
		Html::addCssClass($this->options, 'form-control');
		$this->options['multiple'] = true;
		
		if ($this->hasModel())
		{
			if (! isset($this->model->{$this->attribute}))
			{
				throw new InvalidParamException("Attribute $this->attribute not exists.");
			}
			
			$list = $this->extractSelection($this->items, $this->model->{$this->attribute});
			
			$element = Html::activeListBox($this->model, $this->attribute, $list['selected'], $this->options);
		} else
		{
			if (! is_array($this->selection))
			{
				throw new InvalidParamException('Parameter clientOptions must be an array.');
			}
			
			$list = $this->extractSelection($this->items, $this->selection);
			
			$content = '';
			
			if ($this->label)
			{
				$content .= Html::label($this->label, $this->name, ['class' => 'control-label']);
			}
			
			$content .= Html::listBox($this->name, $this->selection, $list['selected'], $this->options);
			
			if ($this->hint)
			{
				$content .= Html::tag('div', $this->hint, [
					'class' => 'hint-block' 
				]);
			}
			$content .= Html::tag('div', '', [
				'class' => 'help-block' 
			]);
			
			$element = Html::tag('div', $content, [
				'class' => 'form-group' 
			]);
		}
		$this->items_nosel = $list['noselected'];
		
		$this->registerClientScript();
		
		return $element;
	}
	
	/**
	 * Registers the required JavaScript.
	 */
	public function registerClientScript()
	{
		$view = $this->getView();
		ListboxDualAsset::register($view);
		$id = (array_key_exists('id', $this->options)) ? $this->options['id'] : Html::getInputId($this->model, $this->attribute);
		$options = empty($this->clientOptions) ? '' : Json::encode($this->clientOptions);
		$data = Json::encode($this->items_nosel);
		$view->registerJs("$('#$id').listboxdual($options, $data);");
	}
}
