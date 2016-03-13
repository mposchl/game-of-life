<?php
namespace App\DataProvider\Adapter;

interface IAdapter {
	/**
	 * @return mixed
	 */
	public function load();
}