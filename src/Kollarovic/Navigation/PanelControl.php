<?php

namespace Kollarovic\Navigation;


class PanelControl extends BaseControl
{
	
	private $default = [
		'root' => NULL,
		'ajax' => FALSE,
	];


	public function render(array $options = [])
	{
		$options += $this->default;
		$this->extractOptions($options);
		$item = $this->getItemByOptions($options);
		$this->template->items = $this->itemsInPanel($item->getItems());
		$this->template->render();
	}


	private function itemsInPanel($items)
	{
		$itemsInPanel = [];
		foreach($items as $item) {
			if ($item->link == '#') {
				$itemsInPanel = array_merge($itemsInPanel, $this->itemsInPanel($item->getItems()));
			} elseif(!$item->isCurrent() and $item->isActive()) {
				$itemsInPanel[] = $item;
			}
		}
		return $itemsInPanel;
	}

}