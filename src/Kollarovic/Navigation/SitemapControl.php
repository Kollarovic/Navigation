<?php

declare(strict_types=1);

namespace Kollarovic\Navigation;

use Nette\Bridges\ApplicationLatte\Template;

class SitemapControl extends BaseControl
{
    /** @var array<string, mixed> */
	protected array $options = [
		'class' => 'nav',
		'subclass' => 'nav',
	];


	protected function prepareTemplate(Template $template, Item $rootItem): void
	{
		$template->items = $rootItem->getItems();
	}
}
