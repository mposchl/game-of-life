<?php
namespace App\DataProvider\Transformer\Exception;

/**
 * @author Martin Pöschl <martin.poschl@gmail.com>
 */
class XmlElementMissingException extends \Exception {
	public function __construct($element = "", $code = 0, \Exception $previous = null) {
		$this->message = "Element '{$element}' is missing'";
	}
}