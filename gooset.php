<?php 
// Hay que tener la directiva allow_url_include activada
include_once("http://simplehtmldom.svn.sourceforge.net/viewvc/simplehtmldom/tags/v_1_11/simple_html_dom.php?revision=178");
class gooset{
	private $query; //array con palabras clave para buscar
	private $a_elements_google; //array con datos de google que sobran en el html
	private $set; //array final
	
	private function clean_a_elements($a_elements){
		return array_diff($a_elements,array_slice($this->a_elements_google,0));
	}
	
	function gooset(){
		try{
			$this->query = func_get_args();
			if (count($this->query) > 5)
				throw new Exception('5 elementos m&aacute;ximo');
			$this->a_elements_google = array('All About Google','Discuss','Terms of Use','labs.google.com','');
			$url = 'http://labs.google.com/sets?hl=es';
			foreach($this->query as $key => $value){
				$url .= '&q' . ($key+1) . '=' . $value;
			}
			//scraping del html
			$html = file_get_html($url);
			foreach($html->find('a') as $element)
			       $a_elements[] = $element->plaintext;
			$this->set = $this->clean_a_elements($a_elements);
		}catch (exception $e){
			echo 'Error de uso: ' . $e->getMessage();
			die();
		}
		
	}
	
	function get_set(){
		return $this->set;
	}
}
?>