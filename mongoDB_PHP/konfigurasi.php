<?php
require_once "header.php";
include('./httpful.phar');


//konfigurasi windows
$sparql = <<< END
PREFIX mongoDB: <http://www.semanticweb.org/benz/ontologies/2019/10/mongoDB#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>

SELECT DISTINCT ?langkah ?deskripsi
WHERE {
	?konfigurasi rdf:type mongoDB:KonfigurasiWindows.
	?konfigurasi mongoDB:langkah ?langkah.
	?konfigurasi  mongoDB:deskripsi ?deskripsi
	
}
END;
$url = 'http://localhost:3030/mongoDB/query?query=' . urlencode($sparql);
$res = \Httpful\Request::get($url)->expectsJson()->send();
$windows = json_decode($res);


//Konfigurasi Linux
$sparql = <<< END
PREFIX mongoDB: <http://www.semanticweb.org/benz/ontologies/2019/10/mongoDB#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>

SELECT DISTINCT ?langkah ?deskripsi
WHERE {
	
	
	?konfigurasi mongoDB:langkah ?langkah.
	?konfigurasi rdf:type mongoDB:KonfigurasiLinux.
	?konfigurasi  mongoDB:deskripsi ?deskripsi
	
}
END;
$url = 'http://localhost:3030/mongoDB/query?query=' . urlencode($sparql);
$res = \Httpful\Request::get($url)->expectsJson()->send();
$arr = json_decode($res);

?>




	<!-- 2. Menu -->
	<div class="menu1">
		<div class="menu-left1">
			<h1>Konfigurasi <br>di Windows</h1>
			<?php
			$i = 1;
			foreach ($windows->results->bindings as $data) {
			?>
		<div class="s11">
			<h2> <?php echo $i,'. ', $data->langkah->value ?></h2>
			<p>
				<?php		
				echo $data->deskripsi->value
				?>
			</p>
		</div>
		 <?php
 		$i++;
		}
		?>
		</div>

		<div class="menu-right1">
			<h1>Konfigurasi <br>di Linux</h1>
			<?php
			$i = 1;
			foreach ($arr->results->bindings as $data) {
			?>
		<div class="s11">
			<h2> <?php echo $i,'. ', $data->langkah->value ?></h2>
			<p>
				<?php		
				echo $data->deskripsi->value
				?>
			</p>
		</div>
		 <?php
 		$i++;
		}
		?>
		</div>

	</div>

</body>
</html>