<?php

declare(strict_types=1);

namespace Kollarovic\Navigation;

use Nette\Bridges\ApplicationLatte\Template;

class MenuControl extends BaseControl
{
    /** @var array<string, mixed> */
    protected array $options = [
		'class' => 'nav',
		'subclass' => 'nav',
		'activeClass' => 'active',
		'openClass' => 'open',
		'dropdownClass' => 'dropdown',
		'open' => false,
		'deep' => true,
	];


	protected function prepareTemplate(Template $template, Item $rootItem): void
	{
		$template->items = $rootItem->getItems();
	}
}
