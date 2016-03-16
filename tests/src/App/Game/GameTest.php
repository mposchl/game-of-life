<?php
namespace App\Game;

use App\World\Body;
use App\World\Court;
use App\World\Helper\BoundariesHelper;
use App\World\Tenement;

/**
 * @author Martin Pöschl <martin.poschl@gmail.com>
 */
class GameTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @test
	 * @dataProvider dpGetBodies
	 *
	 * @param array $bodies
	 * @param array $expected
	 */
	public function play($bodies, $expected) {
		$tenement = $this->getMockBuilder(Tenement::class)
			->setConstructorArgs([3,1,2])
			->getMock();

		$tenement->method('getBodies')
			->willReturn($bodies);

		$helper = new BoundariesHelper(3);
		$court = new Court($helper);
		$game = new Game($tenement, $court, $helper);

		$this->assertEquals($expected, $game->run()->getBodies());
	}

	public function dpGetBodies() {
		return [
			[
				'bodies' => [
					1 => [
						0 => new Body(1,0,5),
						1 => new Body(1,1,5),
						2 => new Body(1,2,5)
					],
				],
				'ecpected' => [
					0 => [
						1 => new Body(0,1,5) //resurrected
					],
					1 => [
						1 => new Body(1,1,5) //still alive
					],
					2 => [
						1 => new Body(2,1,5) //resurrected
					]
				]
			]
		];
	}
}