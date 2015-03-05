<?php

namespace Kollarovic\Navigation;


class BreadcrumbControl extends BaseControl
{
	
	private $default = [
		'root' => NULL,
		'class' => 'breadcrumb',
	];


	public function render(array $options = [])
	{
		$options += $this->default;
		$item = $this->getItemByOptions($options);
		$this->template->items = $item->getPath();
		$this->template->class = $options['class'];
		$this->template->render();
	}

}