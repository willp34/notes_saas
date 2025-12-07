<?php
namespace App\Controllers\Encoding_methods;
use App\Controllers\BaseController;
use App\Libraries\Huffman\Huffman;
class Huffman_encoding extends BaseController
{
	
	public function index(){
		//$formData = null ;
		
		$formData = $this->request->getJSON(true);
		 
// If no JSON, fallback to POST data (AJAX form-encoded)
		if ($formData === null) {
			return $this->response->setJSON([
				'error' => 'ajax is disabled.'
			]);
		}
		// Validate that JSON exists and contains the key
		if (empty($formData) || empty($formData['encoded_phrase'])) {
			return $this->response->setJSON([
				'error' => 'Input text cannot be empty.'
			]);
		}

		$inputText = trim($formData['encoded_phrase']);

		// Extra safety: reject empty string after trimming
		if ($inputText === '') {
			return $this->response->setJSON([
				'error' => 'Please enter some text to encode.'
			]);
		}
		$huffman = new Huffman($inputText);
		$encodedText = $huffman->process_response();
		$data['encode_text'] = $encodedText;
		$html["html"]= view('/tables/huffmanTable', $data) ;
		// Return the HTML via AJAX
        return $this->response->setJSON($html);
	}
}


?>