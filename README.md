yii2-simple-dual-listbox
============
Simple dual listbox for Yii framework 2.0 or later

Description
-----------

**edwinhaq\simpleduallistbox\SimpleDualListbox** widget is a simple way to control listbox items

Requirements
------------
+ Yii Version 2.0.0 or later

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist edwinhaq/yii2-simple-dual-listbox "*"
```

or add

```
"edwinhaq/yii2-listbox-dual": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php

	use edwinhaq\simpleduallistbox\SimpleDualListbox;
	
	// ... Form definition
	
	$options = [];
	$options['size'] = 10;
	$options['style'] = 'width:200px';
	
	$clientOptions = [];
	$clientOptions['availableListboxPosition'] = "left"; 	// options: left (default), right 
	$clientOptions['upButtonText'] = "UP";	
	$clientOptions['addButtonText'] = "ADD";				
	$clientOptions['addAllButtonText'] = "ADDALL";			
	$clientOptions['remAllButtonText'] = "REMALL";			
	$clientOptions['remButtonText'] = "REM";				
	$clientOptions['downButtonText'] =  "DOWN";				
	$clientOptions['selectedLabel'] =  "Selected";			
	$clientOptions['availableLabel'] = "Available";			
	
	$widgetOptions = [];
	$widgetOptions['label'] = 'Input label';			// Only define when not use model, ignored when model is used
	$widgetOptions['name'] = 'Input name';				// Only define when not use model, ignored when model is used
	$widgetOptions['hint'] = 'Hint';					// Only define when not use model, ignored when model is used
	$widgetOptions['selection'] = [1,2];				// Only define when not use model, ignored when model is used
	$widgetOptions['id'] = 'Input ID';					// If not defined and model is used SimpleDualListbox use Html::getInputId($this->model, $this->attribute)
	$widgetOptions['items'] = ['1' => 'Item1', '2' => 'Item2', '3' => 'Item3',];
	$widgetOptions['options'] = $options;
	$widgetOptions['clientOptions'] = $clientOptions; 
	
	/*
	* With model
	*/
	$model->attribute = [1,2];
				
	$field = $form->field($model, 'attribute')->widget(SimpleDualListbox::className(), $widgetOptions);


	/*
	* Without model
	*/
					
	echo SimpleDualListbox::widget($widgetOptions);
	
	// ... End form definition
	
?>
```

History
-------

+ Version 1.0.0 (2017-05-26)
    + Tested on Yii 2.0.6
