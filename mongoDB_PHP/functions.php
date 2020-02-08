<?php

include('./httpful.phar');
require_once "header.php";

//mengambil arrayQueryOperators
$sparql = <<< END
PREFIX mongoDB: <http://www.semanticweb.org/benz/ontologies/2019/10/mongoDB#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>

SELECT ?fungsi ?type ?tujuan ?contoh ?kembali
WHERE {
	?fungsi rdf:type ?type.
	?type rdfs:subClassOf* mongoDB:SintaksDasar.
	?fungsi mongoDB:fungsiSyntax ?tujuan.
	?fungsi mongoDB:memilikiContoh ?script.
	?script mongoDB:contoh ?contoh.
	?script mongoDB:mengembalikanNilai ?kembali.
	
}
END;
$url = 'http://localhost:3030/mongoDB/query?query=' . urlencode($sparql);
$res = \Httpful\Request::get($url)->expectsJson()->send();
$arr = json_decode($res);

?>


	<!-- 5. Service -->
	<div class="func">
		<h1>Function</h1>
		<?php
			foreach ($arr->results->bindings as $data) {
			?>
		<div class="sfunc">
			
			<h2> <?php echo $data->tujuan->value ?></h2>
			
			<p>
				Contoh: <br>
				<?php echo $data->contoh->value ?>
				<br>
				<br>

				Nilai Kembali: <br>
				<?php		
				echo $data->kembali->value
				?>
			</p>
			<!-- <a href="#">READ MORE</a>
 -->	</div>
 <?php
		}
		?>
 	</div>


 	
 