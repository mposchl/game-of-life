<?php
namespace App\DataProvider;

use App\DataProvider\Adapter\XmlAdapter;

/**
 * @author Martin Pöschl <martin.poschl@gmail.com>
 */
class DataProviderTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @test
	 */
	public function load() {
		$adapter = $this->getMockBuilder(XmlAdapter::class)
			->disableOriginalConstructor()
			->getMock();

		$adapter->method('load')
			->withAnyParameters()
			->willReturn(['a' => 1]);

		$dataProvider = new DataProvider($adapter);

		$this->assertEquals(['a' => 1], $dataProvider->getData());
	}
}