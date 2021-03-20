<?php

namespace app\Services\Routing;

class Registry {
	
	private $data = [];
	
	public function __set($index, $value) {
		$this->data[$index] = $value;
	}
	
	public function __get($index) {
		return $this->data[$index];
	}
	
	public function getData() {
		return $this->data;
	}
	
	
}
