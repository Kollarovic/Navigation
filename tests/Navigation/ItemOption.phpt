<?php

namespace Kollarovic\Navigation\Test;

use Kollarovic\Navigation\Item;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


class ItemOptionTest extends TestCase
{

	public function testOption()
	{
		$item = new Item('test', NULL);
		Assert::same(NULL, $item->getOption('name'));
		Assert::same('defaultValue', $item->getOption('name', 'defaultValue'));
		$item->setOption('name', 'testValue');
		Assert::same('testValue', $item->getOption('name', 'defaultValue'));
	}

}


\run(new ItemOptionTest());