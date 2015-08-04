<?php

namespace Kollarovic\Navigation;


class SitemapControl extends BaseControl
{
	
	private $default = [
		'root' => NULL, 
		'class' => 'nav', 
		'subclass' => "nav",
		'ajax' => FALSE,
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