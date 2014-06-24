<?php

class XPATH {
	public $dom, $xpath, $proxy;

	// constructor recibe url 
	function __construct($url){
		set_time_limit(0); // tiempo ilimitado de ejecucion

		// proxy
		//$this->proxy = $this->__getProxy();

		$html = $this->__curl($url); // obtiene la url
		$this->dom = new DOMDocument(); // nuevo DOM
		@$this->dom->loadHTML($html); // carga del HTML
		$this->xpath = new DOMXPath($this->dom); // nueva instancia xpath
		
	}

	// recibe la expresion xpath

	public function query($q){
		$result = $this->xpath->query($q);
		return $result;
	}

	// recorrido de las propidades y muestra resltados

	public function preview($results){
		echo "<pre>";
		print_r($results);
		echo "<br>Valores <br>";
		foreach($results as $result){
			echo trim($result->nodeValue) . '<br>';
			$array[] = $result;
		}
		if(is_array($array)){
			echo "<br><br>";
			print_r($array);
		}
		
	}

	// obtener la pagina con CURL
	private function __curl($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)");
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);

		// en caso de proxy
		// curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
		// curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);

		// ejecutar 
		$result = curl_exec($ch);

		// errores
		if (!$result) {
			echo "<br />cURL error #:" .curl_errno($ch);
			echo "<br />cURL error:" . curl_error($ch) . " en URL - " . $url;
			var_dump(curl_getinfo($ch));
			var_dump(curl_error($ch));
			exit;
		}
		return $result;
				
	}

	// retorna los proxy randomicos
	private function __getProxy(){
		$fh = fopen("../proxy.txt", 'r+');
		while(!feof($fh)){
			$proxies[] = trim(fgets($fh));
		}
		$proxy = $proxies[array_rand($proxies)]; // selecciona un proxy
		fclose($fh);
		return $proxy;
	}


}
?>