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
	private $items_nosel = [];
	private $id;
	public $items = [];
	public $selection = [];
	public $options = [];
	public $clientOptions = [];
	public $label;
	public $hint;
	public $useGroupDiv = true;
	public $template = '{label}{listbox}{hint}';
	
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
	private function updateListboxOptionTitles($itemlist)
	{
		if (! isset($this->options['options']))
		{
			$this->options['options'] = [];
		}
		
		foreach($itemlist as $k => $v)
		{
			if (isset($this->options['options'][$k]['title']))
			{
			} else
			{
				$this->options['options'][$k]['title'] = $v;
			}
		}
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
			
			$this->id = (array_key_exists('id', $this->options)) ? $this->options['id'] : Html::getInputId($this->model, $this->attribute);
			
			$list = $this->extractSelection($this->items, $this->model->{$this->attribute});
			
			$this->updateListboxOptionTitles($list['selected']);
			
			$element = Html::activeListBox($this->model, $this->attribute, $list['selected'], $this->options);
		} else
		{
			if (! is_array($this->selection))
			{
				throw new InvalidParamException('Parameter clientOptions must be an array.');
			}
			
			$this->id = (array_key_exists('id', $this->options)) ? $this->options['id'] : uniqid('simple_dual_listbox_');
			
			$list = $this->extractSelection($this->items, $this->selection);
			
			$this->updateListboxOptionTitles($list['selected']);
			
			$label = '';
			if ($this->label)
			{
				$label = Html::label($this->label, $this->name, [
					'class' => 'control-label' 
				]);
			}
			
			$hint = '';
			if ($this->hint)
			{
				$hint = Html::tag('div', $this->hint, [
					'class' => 'hint-block' 
				]);
			}
			
			$listbox = Html::listBox($this->name, $this->selection, $list['selected'], $this->options);
			
			/*
			 * $content .= Html::tag('div', '', [
			 * 'class' => 'help-block'
			 * ]);
			 */
			
			$content = $this->template;
			$content = str_replace('{label}', $label, $content);
			$content = str_replace('{listbox}', $listbox, $content);
			$content = str_replace('{hint}', $hint, $content);
			
			if ($this->useGroupDiv)
			{
				$element = Html::tag('div', $content, [
					'class' => 'form-group', 'id' => '',
				]);
			} else
			{
				$element = $content;
			}
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
		SimpleDualListboxAsset::register($view);
		$options = empty($this->clientOptions) ? '' : Json::encode($this->clientOptions);
		$data = Json::encode($this->items_nosel);
		$view->registerJs("$('#$this->id').listboxdual($options, $data);");
	}
}
