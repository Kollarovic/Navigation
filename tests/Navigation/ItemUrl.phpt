<?php

namespace Kollarovic\Navigation\Test;

use Kollarovic\Navigation\Item;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


class ItemUrlTest extends TestCase
{


	/**
	 * @dataProvider getUrlData
	 */
	public function testIsUrl($link, $expected)
	{
		$item = new Item('test', $link);
		Assert::same($item->isUrl(), $expected);
	}


	protected function getUrlData()
	{
		return [
			['Homepage:default', FALSE],
			['//Homepage:default', FALSE],
			['default', FALSE],
			['this', FALSE],
			['#', TRUE],
			['#fragment', TRUE],
			['/page', TRUE],
			['http://example.com', TRUE],
		];
	}

}


\run(new ItemUrlTest());