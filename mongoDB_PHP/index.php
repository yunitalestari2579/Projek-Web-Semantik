<?php
	require_once "header.php";

include('./httpful.phar');
		//Mengambil nama jabatan dari orang
$sparql = <<< END
PREFIX mongoDB: <http://www.semanticweb.org/benz/ontologies/2019/10/mongoDB#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

SELECT ?Orang ?nama ?jabatan
WHERE {?Orang rdf:type mongoDB:Orang . ?Orang mongoDB:nama ?nama . ?Orang mongoDB:jabatan ?jabatan}
END;
$url = 'http://localhost:3030/mongoDB/query?query=' . urlencode($sparql);
$res = \Httpful\Request::get($url)->expectsJson()->send();
$orang = json_decode($res);

//kekurangan mongoDB
$sparql = <<< END
		PREFIX mongoDB: <http://www.semanticweb.org/benz/ontologies/2019/10/mongoDB#>
		PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

		SELECT ?kekurangan ?deskripsi
		WHERE {?kekurangan rdf:type mongoDB:Kekurangan.
			?kekurangan mongoDB:deskripsi ?deskripsi}
END;

			$url = 'http://localhost:3030/mongoDB/query?query=' . urlencode($sparql);
			$res = \Httpful\Request::get($url)->expectsJson()->send();
			$arr = json_decode($res);

			//kelebihan mongoDB
$sparql = <<< END
PREFIX mongoDB: <http://www.semanticweb.org/benz/ontologies/2019/10/mongoDB#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

SELECT ?kelebihan ?deskripsi
WHERE {?kelebihan rdf:type mongoDB:Kelebihan.
	?kelebihan mongoDB:deskripsi ?deskripsi}
END;

	$url = 'http://localhost:3030/mongoDB/query?query=' . urlencode($sparql);
	$res = \Httpful\Request::get($url)->expectsJson()->send();
	$kelebihan = json_decode($res);

//Mengambil deskripsi dari produk
$sparql = <<< END
PREFIX mongoDB: <http://www.semanticweb.org/benz/ontologies/2019/10/mongoDB#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

SELECT ?produk ?deskripsi
WHERE {
	?instance rdf:type mongoDB:Produk .
	?instance mongoDB:nama ?produk .
	?instance mongoDB:deskripsi ?deskripsi}
END;
$url = 'http://localhost:3030/mongoDB/query?query=' . urlencode($sparql);
$res = \Httpful\Request::get($url)->expectsJson()->send();
$produk = json_decode($res);

?>


<body>

	
	<!-- 2. Menu -->
	<div class="menu">
		<div class="menu-left">
			<h1>MongoDB Database</h1>
			<p>MongoDB adalah  produk database noSQL Open Source yang menggunakan struktur data JSON untuk menyimpan datanya. MongoDB sering dipakai untuk aplikasi berbasis Cloud, Grid Computing, atau Big Data. </p>
			<a href="index.php#penemu">Scroll Down</a>
		</div>
		<div class="menu-right">
			<img class="img-orang" src="image/design_mongodb.png" alt="Orang">
		</div>
	</div>

	<!-- 3. Home -->
	<div class="penemu" id="penemu">
		<h1>Penemu MongoDB</h1>
	<div class="home">
		<?php
		foreach ($orang->results->bindings as $data) {?>
	
		<div class="design">
			<img src="image/daun.png" alt="Design">
				
			<h2> <?php echo $data->jabatan->value ?></h2>
			
			<p>
		<?php		
		echo $data->nama->value, '<br>','<br>';
		?>
		
			</p>
		</div>
		<?php
		}
		?>
	</div>
	</div>

	<!-- 4. About -->
	<div class="about">
		<div class="about-kiri">
			<h1>Kekurangan MongoDB</h1>
			<!-- <img src="image/daun.png" alt="Orang"> -->
			<?php
			$i = 1;
			foreach ($arr->results->bindings as $data) {
			?>
			<p> <?php echo $i,'. ', $data->deskripsi->value,'<br>'; ?>
			</p>
			<?php
				$i++;
			}
			?>

		</div>

		<div class="about-kanan">
			<h1>Kelebihan MongoDB</h1>
			<?php
			$i = 1;
			foreach ($kelebihan->results->bindings as $data) {
			?>
			<p> <?php echo $i,'. ', $data->deskripsi->value,'<br>'; ?>
			</p>
			<?php
				$i++;
			}
			?>

		</div>
	</div>

	<!-- 5. Service -->
	<div class="services" id="produk">
		<h1>Produk MongoDB</h1>
		<?php
			foreach ($produk->results->bindings as $data) {
			?>
		<div class="s1">
			
			<img src="image/db.png" alt="Business Inovation">
			<h2> <?php echo $data->produk->value ?></h2>
			<p>
				<?php		
				echo $data->deskripsi->value
				?>
			</p>

 	</div>
 <?php
		}
		?>
 	</div>

 	
 			

		<!-- 6. Portofolio -->
	<div class="portofolio">
		<h1>Operating System for MongoDB</h1>
		<div class="os-kiri">
			<h2>Windows</h2>
			<img src="image/windows.png" alt="">
			
		</div>
		<div class="os-tengah">
			<h2>MacOS</h2>
			<img src="image/mac.png" alt="">
			
		</div>
		<div class="os-kanan">
			<h2>Linux</h2>
			<img src="image/linuk.png" alt="">
			
		</div>
	</div>


	


	<!-- 7. Reviews -->
	<div class="reviews">
		<a href="index.php">Kembali Ke Menu </a>
		<h2>Web Semantik </h2>
		<p>Benyamin - Dharmayasa - Wahyu - Nonny - Yunita</p>
		
	</div>


</body>
