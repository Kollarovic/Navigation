<?php

declare(strict_types=1);

namespace Kollarovic\Navigation;

use Nette\Bridges\ApplicationLatte\Template;


class TitleControl extends BaseControl
{

	protected function prepareTemplate(Template $template, Item $rootItem)
	{
		$template->item = $rootItem->getCurrentItem();
	}

}