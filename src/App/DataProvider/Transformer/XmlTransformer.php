<?php
namespace App\DataProvider\Transformer;

use App\DataProvider\Transformer\Exception\XmlElementMissingException;
use App\World\Body;
use App\World\Tenement;

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
	 * @return Tenement
	 * @throws XmlElementMissingException
	 */
	public function createTenement() {
		$size = (int)$this->getElementByPath('world.cells');
		$iterations = (int)$this->getElementByPath('world.iterations');
		$races = (int)$this->getElementByPath('world.species');

		$tenement = new Tenement($size, $iterations, $races, $this->getBodies());

		return $tenement;
	}

	/**
	 * @return \SimpleXMLElement|\SimpleXMLElement[]
	 * @throws XmlElementMissingException
	 */
	private function getBodies() {
		$bodies = [];
		foreach ($this->getElementByPath('organisms.organism') as $organism) {
			$species = (string)$this->getXmlPath($organism, 'species');
			$storey = (int)$this->getXmlPath($organism, 'x_pos');
			$door = (int)$this->getXmlPath($organism, 'y_pos');

			$bodies[$storey][$door] = new Body($storey, $door, $species);
		}

		return $bodies;
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