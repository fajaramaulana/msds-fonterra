<?php 

function slugify($text, $strict = false)
{
	$text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
	// replace non letter or digits by -
	$text = preg_replace('~[^\\pL\d.]+~u', '-', $text);

	// trim
	$text = trim($text, '-');
	setlocale(LC_CTYPE, 'en_GB.utf8');
	// transliterate
	if (function_exists('iconv')) {
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	}

	// lowercase
	$text = strtolower($text);
	// remove unwanted characters
	$text = preg_replace('~[^-\w.]+~', '', $text);
	if (empty($text)) {
		return 'empty_$';
	}
	if ($strict) {
		$text = str_replace(".", "_", $text);
	}
	return $text;
}

function randString($size) {
	$alpha_key = '';
	$keys_alpha = range('A', 'Z');
	$keys_alpha_dua = range('a', 'z');
	$keys = array_merge($keys_alpha,$keys_alpha_dua);

	for ($i = 0; $i < ($size/2); $i++) {
		$alpha_key .= $keys[array_rand($keys)];
	}

	
	$key = '';
	$keys = range(0, 9);

	for ($i = 0; $i < ($size/2); $i++) {
		$key .= $keys[array_rand($keys)];
	}
	
	$rsl = "";
	$mixk = $alpha_key.$key;
	
	return substr(str_shuffle($mixk),0, $size);
}