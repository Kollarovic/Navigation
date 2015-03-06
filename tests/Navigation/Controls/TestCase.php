<?php

namespace Kollarovic\Navigation\Test\Controls;

use Kollarovic\Navigation\Test\MockPresenter;
use Tester\DomQuery;


abstract class TestCase extends \Kollarovic\Navigation\Test\TestCase
{


	/** @var \Nette\Application\UI\Control */
	protected $control;

	/** @var  string */
	protected $controlClass;


	protected function setUp()
	{
		$this->control = $this->createControl();
	}


	protected function renderControl($options = [], $render = 'render')
	{
		ob_start();
		$this->control->$render($options);
		$html = ob_get_clean();
		return DomQuery::fromHtml($html);
	}


	protected function createControl()
	{
		$container = $this->createContainer();
		$presenter = new MockPresenter();
		$container->callInjects($presenter);
		$rootItem = $this->createItems();

		$control = new $this->controlClass($rootItem);
		$presenter->addComponent($control, 'control');
		return $control;
	}

}
