<?

namespace Kollarovic\Navigation\Test;

use Kollarovic\Navigation\Item;
use Nette\Configurator;


abstract class TestCase extends \Tester\TestCase
{


	protected function createContainer()
	{
		$configurator = new Configurator();
		$configurator->setDebugMode(FALSE);
		$configurator->setTempDirectory(TEMP_DIR);
		$configurator->addConfig(__DIR__ . '/../config.neon');
		return $configurator->createContainer();
	}


	protected function createItems()
	{
		$rootItem = new Item('Homepage', 'Homepage:default');
		$rootItem->addItem('page', 'Page', 'Page:default', 'fa-file-text-o')
			->addItem('list', 'List', 'Page:list');

		$settingItem = $rootItem->addItem('setting', 'Setting', 'Setting:default');
		$settingItem->addItem('base', 'Base', 'Setting:base');

		$advanceItem = $settingItem->addItem('advanced', 'Advanced', 'Setting:advanced');
		$advanceItem->addItem('web', 'Web', 'Setting:web');
		$advanceItem->addItem('mail', 'Mail', 'Setting:mail');

		return $rootItem;
	}

}
