<?php

declare(strict_types=1);

namespace Kollarovic\Navigation;

use Nette\Application\UI\Control;
use Nette\Localization\Translator;


class NavigationControl extends Control
{

	public function __construct(
		private readonly Item $rootItem,
		private readonly Translator $translator = new FallbackTranslator()
	) {
	}


	/**
	 * @param array<string, mixed> $options
	 */
	public function renderMenu(array $options = []): void
	{
		$this['menu']->render($options);
	}


	/**
	 * @param array<string, mixed> $options
	 */
	public function renderBreadcrumb(array $options = []): void
	{
		$this['breadcrumb']->render($options);
	}


	/**
	 * @param array<string, mixed> $options
	 */
	public function renderPanel(array $options = []): void
	{
		$this['panel']->render($options);
	}


	/**
	 * @param array<string, mixed> $options
	 */
	public function renderTitle(array $options = []): void
	{
		$this['title']->render($options);
	}


	protected function createComponentMenu(): MenuControl
	{
		return new MenuControl($this->rootItem, $this->translator);
	}


	protected function createComponentBreadcrumb(): BreadcrumbControl
	{
		return new BreadcrumbControl($this->rootItem, $this->translator);
	}


	protected function createComponentPanel(): PanelControl
	{
		return new PanelControl($this->rootItem, $this->translator);
	}


	protected function createComponentTitle(): TitleControl
	{
		return new TitleControl($this->rootItem, $this->translator);
	}
}
