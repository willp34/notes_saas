<?php

namespace App\Libraries\Huffman;
	class Huffman_Node {
		
		public $char;
		public $freq;
		public $left;
		public $right;
		
		public function  __construct($char,$freq){
			
			$this->char = $char;
			$this->freq= $freq;
			$this->left= null;
			$this->right=null;
		}
}