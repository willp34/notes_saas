<?php
namespace App\Libraries\Huffman;
use App\Libraries\Huffman\Huffman_Node;
	class Huffman {
		private String $inputText;
		
		public function __construct($inputText){
			$this->inputText = $inputText;
		}
	
		 /**
		 * Normalize input (lowercase + strip non-letters).
		 */
		private function normalizeText(string $text): string
		{
			$text = strtolower($text);
			return preg_replace('/[^a-z]/', '', $text);
		}
		private function calculateCharacterFrequencies(): array 
		{
			
			$text  =  $this->normalizeText($this->inputText);
			$frequencyTable  =[];
			for($i=0;$i <strlen($text );$i++){
				$character = $text[$i];
				
				$frequencyTable[$character] =  ($frequencyTable[$character] ?? 0) + 1;;
			
			}
			
			return $frequencyTable;
		}
		
		public function buildHuffmanTree($frequencyTable) : Huffman_Node
		{
			
			$priorityQueue = [];
			
			foreach($frequencyTable  as $char => $f){
				$priorityQueue[] = new Huffman_Node($char,$f);
				
			}
			// Sort by frequency (ascending)
			usort($priorityQueue, fn($a, $b) => $a->freq - $b->freq);
			
			while(count($priorityQueue)> 1){
				
				$leftNode  = array_shift($priorityQueue);
				$rightNode  = array_shift($priorityQueue);
				
				$mergedNode  = new Huffman_Node(null, $leftNode->freq+ $rightNode ->freq);
				$mergedNode->left = $leftNode ;
				$mergedNode->right= $rightNode ;
				
				$priorityQueue[] = $mergedNode ;
				
				 // Re-sort queue
					usort($priorityQueue, fn($a, $b) => $a->freq - $b->freq);
			}
			
			
			return $priorityQueue[0]; //root
		}
		
		/**
		 * Recursively generate the Huffman codebook.
		 */
		private function generateCodebook(?Huffman_Node $node, string $currentCode = "", array &$codebook = []): array
		{
			
			if(!$node) return [];
			
			if($node->char !==null){
				$codebook[$node->char] = $currentCode ;
			}
			
			$this->generateCodebook($node->left, $currentCode ."0", $codebook);
			$this->generateCodebook($node->right, $currentCode ."1", $codebook);
			
			return $codebook;
		}
		
		public function encode(): string
		{
			
			$frequencyTable = $this->calculateCharacterFrequencies();
			$huffmanTree = $this->buildHuffmanTree($frequencyTable);
			$codebook = $this->generateCodebook($huffmanTree);		
			$normalizedText  = $this->normalizeText($this->inputText);
			$encodedText ='';
			
			for($i=0; $i<strlen($normalizedText ); $i++){
				$encodedText .= $codebook[$normalizedText[$i]] ;
			}
			
			return $encodedText  ;
			
		}
		
		public function decode($encoded,$root)
		{
			
			$result = '';
			$node = $root;

			for ($i = 0; $i < strlen($encoded); $i++) {
				$bit = $encoded[$i];
				$node = ($bit === '0') ? $node->left : $node->right;

				if ($node->char !== null) {
					$result .= $node->char;
					$node = $root;
				}
			}

			return $result;
		}
		
		public function process_response() : array
		{
			
			$data_response["Original_text"] = $this->inputText;
			$data_response["Calculate_character_Frequencies"] = $this->calculateCharacterFrequencies() ;
			$data_response["encoded_text"] = $this->encode();
			return $data_response;
		}
		
		
		
		
		
		
	}
?>