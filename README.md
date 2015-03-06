Basic usage
-----------

composer.json

```json
{
    "require":{
        "kollarovic/navigation": "dev-master"
    }
}

```

config.neon

```yaml


extensions:
	thumbnail: Kollarovic\Navigation\DI\Extension


navigation:
	backend:
		label: Homepage
		link: Homepage:default
		items:
			page:
				label: Page
				link: Page:default
			setting:
				label: Setting
				link: Setting:default
				items:
					base:
						label: Base
						link: Setting:base
					advanced:
						label: Advanced
						link: Setting:advanced
						items:
							web:
								label: Web
								link: Setting:web
							mail:
								label: Mail
								link: Setting:mail


```

presenter

```php


use Kollarovic\Navigation\ItemsFactory;
use Kollarovic\Navigation\NavigationControl;
use Kollarovic\Navigation\SitemapControl;


abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	/** @var \Kollarovic\Navigation\ItemsFactory @inject */
	public $itemsFactory;


	protected function createComponentNavigation()
	{
		return new NavigationControl($this->itemsFactory->create('backend'));
	}


	protected function createComponentSitemap()
	{
		return new SitemapControl($this->itemsFactory->create('backend'));
	}

}

```

template.latte

```php

{control navigation:menu}

{control navigation:breadcrumb}

{control navigation:panel}

{control sitemap}

```