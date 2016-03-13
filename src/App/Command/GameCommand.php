<?php
namespace App\Command;

use App\DataProvider\Adapter\XmlAdapter;
use App\DataProvider\DataProvider;
use App\DataProvider\Transformer\XmlTransformer;
use App\Game\Game;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Martin Pöschl <martin.poschl@gmail.com>
 */
class GameCommand extends Command {
	protected function configure() {
		$this
			->setName('play')
			->setDescription('Play the game');
		;

		$this->addOption('input', 'i', InputOption::VALUE_OPTIONAL, 'the input xml file path', 'in.xml');
		$this->addOption('output', 'o', InputOption::VALUE_OPTIONAL, 'the output xml file path', 'out.xml');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$inputFile = $input->getOption('input');
		$dataProvider = new DataProvider(new XmlAdapter($inputFile));
		$xmlData = $dataProvider->getData();

		$transformer = new XmlTransformer($xmlData);
		$world = $transformer->createWorld();

		$game = new Game($world);
		$newWorld = $game->run();

		var_dump($newWorld);
	}
}