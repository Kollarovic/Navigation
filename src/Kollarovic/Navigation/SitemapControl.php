<?php

declare(strict_types=1);

namespace Kollarovic\Navigation;

use Nette\Bridges\ApplicationLatte\Template;

class SitemapControl extends BaseControl
{
	protected $options = [
		'class' => 'nav',
		'subclass' => 'nav',
	];


	protected function prepareTemplate(Template $template, Item $rootItem)
	{
		$template->items = $rootItem->getItems();
	}
}
