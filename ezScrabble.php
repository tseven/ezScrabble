<?php
class Scrabble {
	private $prefix;
	private $suffix;
	private $wordlist;
	private $letters;
	private $solved;
	function __construct($dictionary_file) {
		if(file_exists($dictionary_file)) {
			$words = explode("\r\n", file_get_contents($dictionary_file));
			$list = array();
			foreach($words as $v) {
				$list[strtolower($v)] = true;
			}
			$this->wordlist = $list;
		} else {
			return false;
		}
	}
	function get_words($word){
		$this->letters = $word;
		foreach($this->wordlist as $k=>$v){
			if($this->has_letters($k, $this->prefix.$this->letters.$this->suffix) && ctype_alnum($k)){
				$prefix_pattern = $this->prefix;
				$suffix_pattern = $this->suffix;
				$word_pattern = "([a-z]+?)";
				$regexp = "/{$prefix_pattern}{$word_pattern}{$suffix_pattern}/";
				if(preg_match($regexp, $k) && $this->is_word($k)){
					if(ctype_alnum($this->prefix)){
						$is_match = false;
						if(substr($k, 0, strlen($this->prefix)) == $this->prefix){
							$is_match = true;
						}
					}
					if(ctype_alnum($this->suffix)){
						if(substr($k, 0 - strlen($this->suffix)) == $this->suffix){
							$is_match = true;
						}
					}
					if($is_match == true || !ctype_alnum($this->prefix) && !ctype_alnum($this->suffix)){
						$this->solved[] = $k;
					}
				}
			}
		}
		$results = array();
		foreach($this->solved as $v){
			$results[] =  $v;
		}
		return $results;
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
			'j' => 10,
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
	function is_word($word) {
		if($this->wordlist[$word] == true) {
			return true;
		} else {
			return false;
		}
	}
	function has_letters($word, $letters){
		$count = 0;
		$wordlen = strlen($word);
		/* check to see if each letter of the word is inside our pool of letters */
		for ($i=0; $i < $wordlen; $i++) { 
			$wletter = substr($word, $i, 1);
			$pos = strpos($letters, $wletter);
			/* if the letter is found, remove it from the pool */
			if ($pos !== false) {
				$letters = substr_replace($letters, '', $pos, 1);
				$count++;
			}else{
				/* we're missing a letter, stop the search */
				return false;
			}
		}
		return $count == $wordlen ? true : false;
	}
	function set_var($name, $value){
		$this->$name = $value;
	}
}
?>