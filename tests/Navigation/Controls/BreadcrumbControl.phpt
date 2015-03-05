<?php

namespace Kollarovic\Navigation\Test\Controls;

use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';


class BreadcrumbControlTest extends TestCase
{


	protected $controlClass = 'Kollarovic\Navigation\BreadcrumbControl';


	public function testRender()
	{
		$dom = $this->renderControl(['class' => 'breadcrumb']);
		Assert::true($dom->has('ol.breadcrumb li.active'));
		Assert::count(4, $dom->find('li'));
		Assert::count(3, $dom->find('a'));
		Assert::true($dom->has('a[href="/"]'));
		Assert::true($dom->has('a[href="/setting/default"]'));
		Assert::true($dom->has('a[href="/setting/advanced"]'));

		$active = $dom->find('li.active');
		Assert::count(1, $active);
		Assert::equal('Web', trim($active[0]));
	}


	public function testRenderRootItem()
	{
		$dom = $this->renderControl(['root' => NULL]);
		Assert::count(4, $dom->find('li'));

		$dom = $this->renderControl(['root' => 'setting']);
		Assert::count(2, $dom->find('a'));
		Assert::false($dom->has('a[href="/"]'));
		Assert::true($dom->has('a[href="/setting/default"]'));
		Assert::true($dom->has('a[href="/setting/advanced"]'));

		$active = $dom->find('li.active');
		Assert::count(1, $active);
		Assert::equal('Web', trim($active[0]));
	}

}


\run(new BreadcrumbControlTest());