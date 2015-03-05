<?php

namespace Kollarovic\Navigation\DI;

use Nette\DI\CompilerExtension;


class Extension extends CompilerExtension
{

	public function loadConfiguration()
	{
		$config = $this->getConfig();
		$builder = $this->getContainerBuilder();
		$builder->addDefinition($this->prefix('itemsFactory'))
			->setClass('Kollarovic\Navigation\ItemsFactory', [$config]);
	}

}