<?php
namespace App\DataProvider\XmlWriter;

use App\DataProvider\XmlWriter\Exception\XmlWriterException;
use App\World\Body;
use App\World\Tenement;

/**
 * @author Martin Pöschl <martin.poschl@gmail.com>
 */
class XmlWriter {

	/**
	 * @var string
	 */
	private $path;

	/**
	 * @param string $path
	 */
	public function __construct($path) {
		$this->path = $path;
	}

	/**
	 * @param Tenement $tenement
	 *
	 * @throws XmlWriterException
	 */
	public function write(Tenement $tenement) {
		$xml = new \SimpleXMLElement("<?xml version=\"1.0\" encoding=\"UTF-8\" ?><life></life>");
		$world = $xml->addChild('world');
		$world->addChild('cells', $tenement->size);
		$world->addChild('species', $tenement->races);
		$world->addChild('iterations', $tenement->iterations);

		$orgs = $xml->addChild('organisms');
		foreach ($tenement->getBodies() as $storey => $level) {
			/** @var Body $body */
			foreach ($level as $door => $body) {
				$org = $orgs->addChild('organism');
				$org->addChild('x_pos', $storey);
				$org->addChild('y_pos', $door);
				$org->addChild('species', $body->getRace());
			}
		}

		if (!$xml->saveXML($this->path)) {
			throw new XmlWriterException(error_get_last()['message']);
		}
	}
}