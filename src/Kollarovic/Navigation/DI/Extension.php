<?php

declare(strict_types=1);

namespace Kollarovic\Navigation\DI;

use Kollarovic\Navigation\DefaultItemsFactory;
use Nette\DI\CompilerExtension;


class Extension extends CompilerExtension
{
	public function loadConfiguration()
	{
		$config = $this->getConfig();
		$builder = $this->getContainerBuilder();
		$builder->addDefinition($this->prefix('itemsFactory'))
			->setFactory(DefaultItemsFactory::class, [$config]);
	}
}
