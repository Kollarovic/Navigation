<?php

namespace Kollarovic\Navigation\Test\Controls;

use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';


class NavigationControlTest extends TestCase
{


	protected $controlClass = 'Kollarovic\Navigation\NavigationControl';


	public function testRender()
	{
		$dom = $this->renderControl(['class' => 'breadcrumb'], 'renderBreadcrumb');
		Assert::true($dom->has('ol.breadcrumb li.active'));

		$dom = $this->renderControl(['class' => 'root-class', 'subclass' => 'sub-class'], 'renderMenu');
		Assert::true($dom->has('ul.root-class ul.sub-class li.active'));

		$dom = $this->renderControl([], 'renderPanel');
		Assert::count(2, $dom->find('a'));

		$dom = $this->renderControl([], 'renderTitle');
		echo($dom);
		Assert::contains('Web', (string)$dom->body);
	}

}


\run(new NavigationControlTest());