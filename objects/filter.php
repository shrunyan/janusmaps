<?php



class filter {
  public function input_ary($source) {
		// clean all elements in this array
    if (!empty($source)) {
  		foreach ($source as $i => $source_a) {
  				$source[$i] = $this->input_str($source_a);
      }
		  return $source;
    }
	}
  
  public function input_str($source) {
    //removes \ chars
		$source = str_replace('\\', '', $source);	
    //remove html tags
    $source = strip_tags($source);
		// url decode
		$source = html_entity_decode($source, ENT_QUOTES, "ISO-8859-1");
		// convert decimal
		$source = preg_replace('/&#(\d+);/me',"chr(\\1)", $source);  // decimal notation
		// convert hex
		$source = preg_replace('/&#x([a-f0-9]+);/mei',"chr(0x\\1)", $source);  // hex notation
		
		$source = mysql_real_escape_string($source);
		
		return $source;
  }
  
  
  public function output_str($source, $type) {
    switch($type) {
      case 'string':
        // put in html special chars &ensp;
        $source = htmlspecialchars($source);
        
        //remove all \ characters before quotes
        $source = stripslashes($source);
        break;
      case 'email':
        //remove all \ characters before quotes
        $source = stripslashes($source);
        
        //strip all newline characters
        $source = str_replace(array('\r\n', '\r', '\n'), " ", $source);
        break;
    }
    
    return $source;
    
  }
}

?>