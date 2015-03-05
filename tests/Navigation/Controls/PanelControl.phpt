<?php

namespace Kollarovic\Navigation\Test\Controls;

use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';


class PanelControlTest extends TestCase
{


	protected $controlClass = 'Kollarovic\Navigation\PanelControl';


	public function testRender()
	{
		$dom = $this->renderControl();
		Assert::count(2, $dom->find('a'));
		Assert::true($dom->has('a[href="/page/default"]'));
		Assert::true($dom->has('a[href="/setting/default"]'));
	}


	public function testRenderRootItem()
	{
		$dom = $this->renderControl(['root' => NULL]);
		Assert::count(2, $dom->find('a'));
		Assert::true($dom->has('a[href="/setting/default"]'));

		$dom = $this->renderControl(['root' => 'setting']);
		Assert::count(2, $dom->find('a'));
		Assert::false($dom->has('a[href="/setting/default"]'));
		Assert::true($dom->has('a[href="/setting/base"]'));
		Assert::true($dom->has('a[href="/setting/advanced"]'));
	}


}


\run(new PanelControlTest());