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
		$this->extractOptions($options);
		$item = $this->getItemByOptions($options);
		$this->template->items = $item->getItems();
		$this->template->render();
	}

}