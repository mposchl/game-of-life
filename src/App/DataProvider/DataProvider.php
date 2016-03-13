<?php
namespace App\DataProvider;

use App\DataProvider\Adapter\IAdapter;

/**
 * @author Martin Pöschl <martin.poschl@gmail.com>
 */
class DataProvider {

	/**
	 * @var IAdapter
	 */
	private $adapter;

	/**
	 * @param IAdapter $adapter
	 */
	public function __construct(IAdapter $adapter) {
		$this->adapter = $adapter;
	}

	/**
	 * @return mixed
	 */
	public function getData() {
		return $this->adapter->load();
	}
}