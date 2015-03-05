<?php

namespace Kollarovic\Navigation;


class MenuControl extends BaseControl
{
	
	private $default = [
		'root' => NULL, 
		'class' => 'nav', 
		'subclass' => "nav", 
		'open' => FALSE,
		'deep' => TRUE,
	];


	public function render(array $options = [])
	{
		$options += $this->default;
		$item = $this->getItemByOptions($options);
		$this->template->items = $item->getItems();
		$this->template->class = $options['class'];
		$this->template->subclass = $options['subclass'];
		$this->template->open = $options['open'];
		$this->template->deep = $options['deep'];
		$this->template->render();
	}

}