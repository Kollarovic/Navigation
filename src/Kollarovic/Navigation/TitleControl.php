<?php

namespace Kollarovic\Navigation;


class TitleControl extends BaseControl
{
	
	private $default = [
		'root' => NULL,
	];


	public function render(array $options = [])
	{
		$options += $this->default;
		$this->extractOptions($options);
		$item = $this->getItemByOptions($options);
		$this->template->item = $item->getCurrentItem();
		$this->template->render();
	}

}