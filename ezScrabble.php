<?php
class Scrabble {
	private $prefix;
	private $suffix;
	private $wordlist;
	function __Construct($dictionary_file) {
		if(file_exists($dictionary_file)) {
			$words = explode("\r\n", file_get_contents($dictionary_file));
			$list = array();
			foreach($words as $v) {
				$list[$v] = true;
			}
			$this -> wordlist = $list;
		} else {
			return false;
		}
	}
	function permutations($letters,$num){ 
	    $last = str_repeat($letters{0},$num); 
	    $result = array(); 
	    while($last != str_repeat($this->lastchar($letters),$num)){ 
	        $result[] = $last; 
	        $last = $this->char_add($letters,$last,$num-1); 
	    } 
	    $result[] = $last; 
	    return $result; 
	} 
	function calculate_points($word){
		$letters = str_split($word);
		$values = array(
			'a' => 1,
			'b' => 4,
			'c' => 4,
			'd' => 2,
			'e' => 1,
			'f' => 4,
			'g' => 3,
			'h' => 3,
			'i' => 1,
			'j' => '10',
			'k' => 5,
			'l' => 2,
			'm' => 4,
			'n' => 2,
			'o' => 1,
			'p' => 4,
			'q' => 10,
			'r' => 1,
			's' => 1,
			't' => 1,
			'u' => 2,
			'v' => 5,
			'w' => 4,
			'x' => 8,
			'y' => 3,
			'z' => 10
		);
		$score = 0;
		foreach($letters as $v){
			$score = $score + $values[$v];
		}
		return $score;
	}
	function char_add($digits,$string,$char){ 
	    IF($string{$char} <> $this->lastchar($digits)){ 
	        $string{$char} = $digits{strpos($digits,$string{$char})+1}; 
	        return $string; 
	    }else{ 
	        $string = $this->changeall($string,$digits{0},$char); 
	        return $this->char_add($digits,$string,$char-1); 
	    } 
	} 
	function lastchar($string){ 
	    return $string{strlen($string)-1}; 
	} 
	function changeall($string,$char,$start = 0,$end = 0){ 
	    if($end == 0) $end = strlen($string)-1; 
	    for($i=$start;$i<=$end;$i++){ 
	        $string{$i} = $char; 
	    } 
	    return $string; 
	} 
	function get_words($letters){
		$unique = implode("",array_unique(str_split($letters)));
		$matches = array();
		$combinations = $this->get_combinations($unique);
		if(is_array($combinations)){
			foreach($combinations as $k=>$v){
				if($this->is_word($this->prefix.$v.$this->suffix) && $this->has_letters($v, $v->prefix.$letters.$v->suffix)){
					array_push($matches, $this->prefix.$v.$this->suffix);
				}
			}
		}
		return $matches;
	}
	function get_combinations($word){
		$combinations = array();
		for($i = 1; $i <= strlen($word); $i++){
			$tmp = $this->permutations($word, $i); 
			$combinations = array_merge($combinations, $tmp);
		}
		return $combinations;
	}
	function has_letters($word, $letters){
		foreach (count_chars($word, 1) as $i => $val) {
			$wordcount[chr($i)] = $val;
		}	
		foreach(count_chars($letters, 1) as $k=>$v){
			$lettercount[chr($k)] = $v;
		}
		$go = true;
		foreach($wordcount as $k=>$v){
			if($lettercount[$k] < $v){
				$go = false;
			}
		}
		return $go;
	}
	function is_word($word) {
		if($this->wordlist[$word] == true) {
			return true;
		} else {
			return false;
		}
	}
	function set_var($name, $value){
		$this->$name = $value;
	}
	function get_var($name){
		return $this->$name;
	}
}
?>