<?php
class Prime {
	private $end;
	private $primes;
	private $perfects;
    
	public function __construct($end = 1000) {
		$this->end = $end + 1;
		$this->primes[1] = false;
		for ($i = 2; $i < $this->end; $i++) {
			$this->primes[$i] = true;
		}
		for ($p = 1; $p < $this->end; $p++){
			$this->perfects[$p] = false;
		}
		for ($n = 2; $n < $this->end; $n++) {
			if ($this->primes[$n]) {
				for ($i = $n*$n; $i < $this->end; $i += $n) {
					$this->primes[$i] = false;
				}	
			}
		}
		for ($q = 1; $q < $this->end; $q++) {
			$sum = 0;
			for($i = 2; $i <= sqrt($q); $i++)
			{
				if(!($q % $i)){
					$sum += $i;
					if ($i <> $q / $i){
						$sum += $q / $i;
					}
				}
			}	
			if  (($sum+1) == $q){
				$perfects[$q] = true;
			}
		}
		return;
	}
	public function isPrime($n) {
		// return ( array_key_exists($n, $this->primes) ? $this->primes[$n] : false);
        return $this->primes[$n];
	}
	
	public function isPerfect($n) {
        // return ( array_key_exists($n, $this->perfects) ? $this->perfects[$n] : false);
        return $this->perfects[$n];
	}
	
	public function printPrime() {
		for ($n = 1; $n < $this->end; $n++) {
			print("Is $n a prime number? -->" . ($this->isPrime($n) ? "PRIME" : "NOT PRIME") . "<br />");
		}
		return;
	}
	public function __destruct() {
		$this->end = 0;
		unset($primes);
		unset($perfects);
		return;
	}
}

function prep_table($file_arr, $param_arr) {
	$prime = new Prime($param_arr[1]);
	unset($file_arr[0]);
	sort($file_arr, SORT_NUMERIC);
	$table_html = "";
	$k = 0;
	$ubound = round(($param_arr[0] / 10), 0);
	for($i = 1; $i <= $ubound; $i++) {
		$table_html .= "<tr>" . PHP_EOL;
		for($j = 1; $j <= 10; $j++) {
			if ($k <= ($param_arr[0] - 1)) {
				$prime_color_spec = $prime->isPrime($file_arr[$k]) ? "bgcolor=\"$param_arr[2]\"" : ($prime->isPerfect($file_arr[$k]) ? "bgcolor=\"$param_arr[3]\"" : "bgcolor=\"$param_arr[4]\"");
				$table_html .= "<td $prime_color_spec class=\"table-cell-style\">$file_arr[$k]</td>" . PHP_EOL;
			}
			else {
				$table_html .= "<td bgcolor=\"white\" class=\"table-cell-style\">&nbsp;</td>" . PHP_EOL;
			}
			$k++;
		}
		$table_html .= "</tr>" . PHP_EOL;
	}
	return $table_html;
}

$file = file_get_contents("input_file.txt");
$file_arr = explode(PHP_EOL, $file);
$param_arr = explode(",", $file_arr[0]);
$table_content = prep_table($file_arr, $param_arr);
$html = <<<_HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="en-us" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Prime Numbers Table</title>
<style type="text/css">
.key-text-style {
color: #FFFFFF;
}
.table-style {
border-collapse: collapse;
border-style: solid;
border-width: 1px;
color: #FFFFFF;
}
.table-cell-style {
border-width: 1px;
border-style: solid;
border-width: 1px;
color: #FFFFFF;
}
</style>
</head>
<body>
<table style="width: 60%" class="table-style">
$table_content
</table>
<p><strong>Key</strong></p>
<table style="width: 15%" class="table-style">
<tr>
<td bgcolor="$param_arr[2]" class="key-text-style">Prime</td>
</tr>
<tr>
<td bgcolor="$param_arr[3]" class="key-text-style">Perfect Prime</td>
</tr>
<tr>
<td bgcolor="$param_arr[4]" class="key-text-style">Not Prime</td>
</tr>
</table>
</body>
</html>
_HTML;
echo $html;
?>
