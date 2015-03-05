<?php

namespace Kollarovic\Navigation\Test;

use Kollarovic\Navigation\Item;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


class ItemValueTest extends TestCase
{


	public function testValue()
	{
		$item = new Item('test', '#');
		$item->setValue(40);
		Assert::same(40, $item->getValue());
		$item->setValue(function(Item $item){ return 10;});
		Assert::same(10, $item->getValue());
	}

}


\run(new ItemValueTest());