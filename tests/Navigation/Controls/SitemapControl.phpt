<?php

namespace Kollarovic\Navigation\Test\Controls;

use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';


class SitemapControlTest extends TestCase
{


	protected $controlClass = 'Kollarovic\Navigation\SitemapControl';


	public function testRender()
	{
		$dom = $this->renderControl(['class' => 'root-class', 'subclass' => 'sub-class']);
		Assert::count(7, $dom->find('a'));
		Assert::true($dom->has('ul.root-class ul.sub-class'));
		Assert::true($dom->has('a[href="/page/default"]'));
		Assert::true($dom->has('a[href="/page/default"]'));
		Assert::true($dom->has('a[href="/setting/default"]'));
		Assert::true($dom->has('ul ul a[href="/setting/base"]'));
	}

}


\run(new SitemapControlTest());