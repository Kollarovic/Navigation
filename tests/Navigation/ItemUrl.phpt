<?php
declare(strict_types=1);

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
			['Homepage:default', false],
			['//Homepage:default', false],
			['default', false],
			['this', false],
			['#', true],
			['#fragment', true],
			['/page', true],
			['http://example.com', true],
		];
	}
}


\run(new ItemUrlTest());
