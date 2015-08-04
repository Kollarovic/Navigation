<?php

namespace Kollarovic\Navigation;


class BreadcrumbControl extends BaseControl
{
	
	private $default = [
		'root' => NULL,
		'class' => 'breadcrumb',
		'ajax' => FALSE,
	];


	public function render(array $options = [])
	{
		$options += $this->default;
		$this->extractOptions($options);
		$item = $this->getItemByOptions($options);
		$this->template->items = $item->getPath();
		$this->template->render();
	}

}