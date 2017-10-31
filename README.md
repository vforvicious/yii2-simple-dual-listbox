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
"edwinhaq/yii2-simple-dual-listbox": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php

	use edwinhaq\simpleduallistbox\SimpleDualListbox;

	// ... Form definition

	$items = ['1' => 'Item1', '2' => 'Item2', '3' => 'Item3',];

	$options = [];
	$options['size'] = 10;
	$options['style'] = 'width:200px';
	$options['options'] = [];		// If 'title' not defined SimpleDualListbox defines it for each option item

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
	$widgetOptions['label'] = 'InputLabel'; // Ignored when model is used
	$widgetOptions['name'] = 'InputName'; // Ignored when model is used
	$widgetOptions['hint'] = 'Hint'; // Ignored when model is used
	$widgetOptions['selection'] = [1,2]; // Ignored when model is used
	$widgetOptions['id'] = 'Input ID'; // Optional
	$widgetOptions['template'] = '{label}{listbox}{hint}'; // Used to generate element, by default '{label}{listbox}{hint}'
	$widgetOptions['useGroupDiv'] = true; // true by default. Wrap element in a div tag: <div class="form-group"> ... </div>,
	$widgetOptions['items'] = $items;
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

```

History
-------

+ Version 1.0.0 (2017-05-28)
    + Tested on Yii 2.0.6
+ Version 1.0.1 (2017-10-31)
    + Tested on Yii 2.0.12