<?php
namespace App\DataProvider\Transformer;

use App\World\Body;
use App\World\Tenement;

/**
 * @author Martin Pöschl <martin.poschl@gmail.com>
 */
class XmlTransformerTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @test
	 * @expectedException \App\DataProvider\Transformer\Exception\XmlElementMissingException
	 */
	public function elementMissing() {
		(new XmlTransformer(simplexml_load_file(__DIR__.'/data/element_mis.xml')))->createTenement();
	}

	/**
	 * @test
	 * @expectedException \App\DataProvider\Transformer\Exception\XmlElementMissingException
	 */
	public function subElementMissing() {
		(new XmlTransformer(simplexml_load_file(__DIR__.'/data/subelement_mis.xml')))->createTenement();
	}

	/**
	 * @test
	 */
	public function transformOk() {
		$tenement = new Tenement(5, 2, 1, [1 => [0 => new Body(1,0,5)]]);

		$this->assertEquals($tenement, (new XmlTransformer(simplexml_load_file(__DIR__.'/data/ok.xml')))->createTenement());
	}
}