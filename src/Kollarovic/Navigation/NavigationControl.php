<?php

namespace Kollarovic\Navigation;

use Nette\Application\UI\Control;


class NavigationControl extends Control
{


	/** @var Item */
	private $rootItem;


	function __construct(Item $rootItem)
	{
		$this->rootItem = $rootItem;
	}


	public function renderMenu(array $options = [])
	{
		$this['menu']->render($options);
	}


	public function renderBreadcrumb(array $options = [])
	{
		$this['breadcrumb']->render($options);
	}


	public function renderPanel(array $options = [])
	{
		$this['panel']->render($options);
	}


	public function renderTitle()
	{
		echo $this->rootItem->getCurrentItem();
	}


	protected function createComponentMenu()
	{
		return new MenuControl($this->rootItem);
	}


	protected function createComponentBreadcrumb()
	{
		return new BreadcrumbControl($this->rootItem);
	}


	protected function createComponentPanel()
	{
		return new PanelControl($this->rootItem);
	}

}