<?php

namespace Kollarovic\Navigation;

use Nette\Application\UI\Control;
use Nette\Localization\ITranslator;


class NavigationControl extends Control
{


	/** @var Item */
	private $rootItem;

	/** @var ITranslator */
	private $translator;


	function __construct(Item $rootItem, ITranslator $translator = null)
	{
		$this->rootItem = $rootItem;
		$this->translator = $translator;
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


	public function renderTitle(array $options = [])
	{
		$this['title']->render($options);
	}


	protected function createComponentMenu()
	{
		return new MenuControl($this->rootItem, $this->translator);
	}


	protected function createComponentBreadcrumb()
	{
		return new BreadcrumbControl($this->rootItem, $this->translator);
	}


	protected function createComponentPanel()
	{
		return new PanelControl($this->rootItem, $this->translator);
	}


	protected function createComponentTitle()
	{
		return new TitleControl($this->rootItem, $this->translator);
	}

}