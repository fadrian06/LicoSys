<?php

	function getAPI(string $url, string $urlJSON): array{
		$data = @file_get_contents($url) ?: @file_get_contents($urlJSON);
		@file_put_contents($urlJSON, $data);
		$data = json_decode($data, true, 512, JSON_INVALID_UTF8_IGNORE);

		return $data;
	}

	$url = 'https://s3.amazonaws.com/dolartoday/data.json';
	$json  = 'json/dolarToday.json';
	$data = getAPI($url, $json);
	$dolarFecha = $data['_timestamp']['fecha'];
	$dolarT     = $data['USD']['transferencia'];
	$dolarE     = $data['USD']['efectivo'];

	$url = 'https://api.exchangedyn.com/markets/quotes/usdves/bcv';
	$json = 'json/bcv.json';
	$data = getAPI($url, $json);
	$dolarBCV = round($data['sources']['BCV']['quote'], 2);

?>