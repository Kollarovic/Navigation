<?php

namespace Kollarovic\Navigation;


class SitemapControl extends BaseControl
{
	
	private $default = [
		'root' => NULL, 
		'class' => 'nav', 
		'subclass' => "nav", 
	];


	public function render(array $options = [])
	{
		$options += $this->default;
		$item = $this->getItemByOptions($options);
		$this->template->items = $item->getItems();
		$this->template->class = $options['class'];
		$this->template->subclass = $options['subclass'];
		$this->template->render();
	}

}