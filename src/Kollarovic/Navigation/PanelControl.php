<?php

declare(strict_types=1);

namespace Kollarovic\Navigation;

use Nette\Bridges\ApplicationLatte\Template;

class PanelControl extends BaseControl
{
	protected function prepareTemplate(Template $template, Item $rootItem): void
	{
		$template->items = $this->itemsInPanel($rootItem->getItems());
	}


	/**
	 * @param array<Item> $items
	 * @return array<Item>
	 */
	private function itemsInPanel(array $items): array
	{
		$itemsInPanel = [];
		foreach ($items as $item) {
			if ($item->getLink() == '#') {
				$itemsInPanel = array_merge($itemsInPanel, $this->itemsInPanel($item->getItems()));
			} elseif (!$item->isCurrent() and $item->isActive()) {
				$itemsInPanel[] = $item;
			}
		}
		return $itemsInPanel;
	}
}
