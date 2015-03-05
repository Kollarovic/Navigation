<?php

namespace Kollarovic\Navigation\Test;

use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


class ItemDropdownTest extends TestCase
{

	public function testDropdown()
	{
		$rootItem = $this->createItems();
		Assert::true($rootItem->isDropdown());
		Assert::true($rootItem['page']->isDropdown());
		Assert::true($rootItem['setting']->isDropdown());
		Assert::false($rootItem['setting']['base']->isDropdown());
		Assert::true($rootItem['setting']['advanced']->isDropdown());
		Assert::false($rootItem['setting']['advanced']['web']->isDropdown());
		Assert::false($rootItem['setting']['advanced']['mail']->isDropdown());
	}

}


\run(new ItemDropdownTest());