<?
##ezScrabble by s0up(mike@haxt.net)##
include 'ezScrabble.php';
$start = getTime();
$scrabble = new Scrabble("wordlist");

$letters = "adoomfcs";
$prefix = "";
$suffix = "re";

$scrabble->set_var("prefix", $prefix);
$scrabble->set_var("suffix", $suffix);

print_r($scrabble->get_words($letters));

$end = getTime(); 
echo "Time taken = " . number_format(($end - $start), 2) . " secs\n";

function getTime(){ 
  $a = explode (' ',microtime()); 
  return(double) $a[0] + $a[1]; 
} 
