<?php
namespace App\Command;

use App\DataProvider\Adapter\XmlAdapter;
use App\DataProvider\DataProvider;
use App\DataProvider\Transformer\XmlTransformer;
use App\DataProvider\XmlWriter\XmlWriter;
use App\Game\Game;
use App\World\Court;
use App\World\Helper\BoundariesHelper;
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
		// load xml data
		$inputFile = $input->getOption('input');
		$dataProvider = new DataProvider(new XmlAdapter($inputFile));
		$xmlData = $dataProvider->getData();

		// transform xml data to game data
		$transformer = new XmlTransformer($xmlData);
		$tenement = $transformer->createTenement();

		// prepare all entities for gameplay
		$helper = new BoundariesHelper($tenement->size);
		$court = new Court($helper);
		$game = new Game($tenement, $court, $helper);

		// play the game
		$tenementPlus = $game->run();

		// export state to xml
		$outputFile = $input->getOption('output');
		$writer = new XmlWriter($outputFile);
		$writer->write($tenementPlus);
	}
}