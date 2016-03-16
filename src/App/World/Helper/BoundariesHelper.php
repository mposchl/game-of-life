<?php
namespace App\World\Helper;

/**
 * @author Martin Pöschl <martin.poschl@gmail.com>
 */
class BoundariesHelper {

	/**
	 * @var int
	 */
	private $tenementSize;

	/**
	 * @param $tenementSize
	 */
	public function __construct($tenementSize) {
		$this->tenementSize = $tenementSize;
	}

	/**
	 * get lower coordinate bound of the world/graveyard relatively to given coord
	 *
	 * @param int $coord
	 *
	 * @return int
	 */
	public function getMin($coord) {
		return max($coord - 1, 0);
	}

	/**
	 * get higher coordinate bound of the world/graveyard relatively to given coord
	 *
	 * @param int $coord
	 *
	 * @return int
	 */
	public function getMax($coord) {
		return min($coord + 1, $this->tenementSize - 1);
	}
}