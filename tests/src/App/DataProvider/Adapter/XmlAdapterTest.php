<?php
namespace App\DataProvider\Adapter;

/**
 * @author Martin Pöschl <martin.poschl@gmail.com>
 */
class XmlAdapterTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @test
	 * @expectedException \App\DataProvider\Adapter\Exception\XmlAdapterFileNotFoundException
	 */
	public function fileNotFound() {
		$adapter = new XmlAdapter('not_found.xml');
		$adapter->load();
	}

	/**
	 * @test
	 * @expectedException \App\DataProvider\Adapter\Exception\XmlAdapterException
	 */
	public function notWellFormed() {
		$adapter = new XmlAdapter(__DIR__.'/data/not_wellformed.xml');
		$adapter->load();
	}

	/**
	 * @test
	 */
	public function wellFormed() {
		$adapter = new XmlAdapter(__DIR__.'/data/wellformed.xml');
		$element = $adapter->load();

		$this->assertInstanceOf('\SimpleXMLElement', $element);
	}
}