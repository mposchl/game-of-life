<?php
namespace App\DataProvider\Adapter;

use App\DataProvider\Adapter\Exception\XmlAdapterException;
use App\DataProvider\Adapter\Exception\XmlAdapterFileNotFoundException;

/**
 * @author Martin Pöschl <martin.poschl@gmail.com>
 */
class XmlAdapter implements IAdapter {

	/**
	 * @var string
	 */
	private $filePath;

	/**
	 * @param string $filePath
	 */
	public function __construct($filePath) {
		$this->filePath = $filePath;
	}

	/**
	 * @return \SimpleXMLElement
	 * @throws XmlAdapterException
	 * @throws XmlAdapterFileNotFoundException
	 */
	public function load() {
		if (!file_exists($this->filePath)) {
			throw new XmlAdapterFileNotFoundException;
		}

		libxml_use_internal_errors(true);
		$xml = simplexml_load_file($this->filePath);

		if (!$xml) {
			$error = libxml_get_last_error();
			throw new XmlAdapterException($error->message);
		}
		libxml_use_internal_errors(false);

		return $xml;
	}
}