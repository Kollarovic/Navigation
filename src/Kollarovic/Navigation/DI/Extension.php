<?php

namespace Kollarovic\Navigation\DI;

use Kollarovic\Navigation\ItemsFactory;
use Nette\DI\CompilerExtension;


class Extension extends CompilerExtension
{

	public function loadConfiguration()
	{
		$config = $this->getConfig();
		$builder = $this->getContainerBuilder();
		$builder->addDefinition($this->prefix('itemsFactory'))
			->setFactory(ItemsFactory::class, [$config]);
	}

}