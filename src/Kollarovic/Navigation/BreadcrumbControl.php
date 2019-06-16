<?php

declare(strict_types=1);

namespace Kollarovic\Navigation;

use Nette\Bridges\ApplicationLatte\Template;


class BreadcrumbControl extends BaseControl
{

	protected $options = [
		'class' => 'breadcrumb',
	];


	protected function prepareTemplate(Template $template, Item $rootItem)
	{
		$template->items = $rootItem->getPath();
	}

}