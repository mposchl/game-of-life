<?php
namespace App\DataProvider\Transformer;

use App\DataProvider\Transformer\Exception\XmlElementMissingException;
use App\World\Organism;
use App\World\World;

/**
 * @author Martin Pöschl <martin.poschl@gmail.com>
 */
class XmlTransformer {

	/**
	 * @var \SimpleXMLElement
	 */
	private $xml;

	/**
	 * @param \SimpleXMLElement $xml
	 */
	public function __construct(\SimpleXMLElement $xml) {
		$this->xml = $xml;
	}

	/**
	 * @return World
	 * @throws XmlElementMissingException
	 */
	public function createWorld() {
		$size = (int)$this->getElementByPath('world.cells');
		$iterations = (int)$this->getElementByPath('world.iterations');
		$species = (int)$this->getElementByPath('world.species');

		$state = new World($size, $iterations, $species);
		$state->setOrganisms($this->getOrganisms());

		return $state;
	}

	/**
	 * @return \SimpleXMLElement|\SimpleXMLElement[]
	 * @throws XmlElementMissingException
	 */
	private function getOrganisms() {
		$newOrganisms = [];
		foreach ($this->getElementByPath('organisms.organism') as $organism) {
			$species = (string)$this->getXmlPath($organism, 'species');
			$x = (int)$this->getXmlPath($organism, 'x_pos');
			$y = (int)$this->getXmlPath($organism, 'y_pos');
			$newOrganism = new Organism($x, $y, $species);

			$newOrganisms[$x][$y] = $newOrganism;
		}

		return $newOrganisms;
	}

	/**
	 * @param string $path path divided by dot [element[.subelement[.subsub]]]
	 *
	 * @return \SimpleXMLElement|\SimpleXMLElement[]
	 * @throws XmlElementMissingException
	 */
	private function getElementByPath($path) {
		$xml = clone $this->xml;

		return $this->getXmlPath($xml, $path);
	}

	/**
	 * @param \SimpleXMLElement $xml
	 * @param string $path
	 *
	 * @return mixed
	 * @throws XmlElementMissingException
	 */
	private function getXmlPath($xml, $path) {
		foreach (explode('.', $path) as $chunk) {
			if (!isset($xml->$chunk)) {
				throw new XmlElementMissingException($chunk);
			}
			$xml = clone $xml->$chunk;
		}
		return $xml;
	}
}