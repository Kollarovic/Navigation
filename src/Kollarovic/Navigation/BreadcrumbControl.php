<?php

declare(strict_types=1);

namespace Kollarovic\Navigation;

use Nette\Bridges\ApplicationLatte\Template;

class BreadcrumbControl extends BaseControl
{
    /** @var array<string, mixed> */
	protected array $options = [
		'class' => 'breadcrumb',
	];


	protected function prepareTemplate(Template $template, Item $rootItem): void
	{
		$template->items = $rootItem->getPath();
	}
}
