<?php

namespace Kollarovic\Navigation\Test\Controls;

use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';


class MenuControlTest extends TestCase
{


	protected $controlClass = 'Kollarovic\Navigation\MenuControl';


	public function testRender()
	{
		Assert::true($this->control->rootItem['setting']['advanced']['web']->isCurrent());
		Assert::false($this->control->rootItem['page']->isOpen());

		$dom = $this->renderControl(['class' => 'root-class', 'subclass' => 'sub-class']);
		Assert::count(6, $dom->find('a'));
		Assert::true($dom->has('ul.root-class ul.sub-class'));
		Assert::true($dom->has('li.active'));
		Assert::true($dom->has('li.open'));
		Assert::true($dom->has('a[href="/page/default"]'));
		Assert::true($dom->has('a[href="/page/default"] i[class="fa fa-fw fa-file-text-o"]'));
		Assert::true($dom->has('a[href="/setting/default"]'));
		Assert::true($dom->has('ul ul a[href="/setting/base"]'));
	}


	public function testMenuOpen()
	{
		$dom = $this->renderControl(['open' => TRUE]);
		Assert::count(7, $dom->find('a'));
		Assert::true($dom->has('ul ul a[href="/page/list"]'));

		$dom = $this->renderControl(['open' => FALSE]);
		Assert::count(6, $dom->find('a'));
		Assert::false($dom->has('ul ul a[href="/page/list"]'));
	}


	public function testMenuDeep()
	{
		$dom = $this->renderControl(['deep' => TRUE]);
		Assert::count(6, $dom->find('a'));
		Assert::true($dom->has('ul ul a[href="/setting/advanced"]'));
		Assert::true($dom->has('ul ul ul a[href="/setting/web"]'));

		$dom = $this->renderControl(['deep' => FALSE]);
		Assert::count(2, $dom->find('a'));
		Assert::false($dom->has('ul ul a[href="/setting/advanced"]'));
		Assert::false($dom->has('ul ul ul a[href="/setting/web"]'));

		$dom = $this->renderControl(['deep' => 1]);
		Assert::count(4, $dom->find('a'));
		Assert::true($dom->has('ul ul a[href="/setting/advanced"]'));
		Assert::false($dom->has('ul ul ul a[href="/setting/web"]'));

		$dom = $this->renderControl(['deep' => 2]);
		Assert::count(6, $dom->find('a'));
		Assert::true($dom->has('ul ul a[href="/setting/advanced"]'));
		Assert::true($dom->has('ul ul ul a[href="/setting/web"]'));
	}


	public function testRootItem()
	{
		$dom = $this->renderControl(['root' => NULL]);
		Assert::count(6, $dom->find('a'));
		Assert::true($dom->has('ul ul a[href="/setting/base"]'));

		$dom = $this->renderControl(['root' => 'setting']);
		Assert::count(4, $dom->find('a'));
		Assert::false($dom->has('ul ul a[href="/setting/base"]'));
		Assert::true($dom->has('ul a[href="/setting/base"]'));

		$dom = $this->renderControl(['root' => 'setting-advanced']);
		Assert::count(2, $dom->find('a'));
		Assert::true($dom->has('ul a[href="/setting/web"]'));
		Assert::true($dom->has('ul a[href="/setting/mail"]'));
	}


	public function tesActiveItem()
	{
		$this->control['root']['setting']['base']->setActive(FALSE);
		$dom = $this->renderControl();
		Assert::false($dom->has('a[href="/setting/base"]'));

		$this->control['root']['setting']['base']->setActive(TRUE);
		$dom = $this->renderControl();
		Assert::true($dom->has('a[href="/setting/base"]'));
	}

}


\run(new MenuControlTest());