<?php
include('./httpful.phar');
$mongoDB = "http://www.semanticweb.org/benz/ontologies/2019/10/mongoDB#";
$replace = "mongoDB:";
$cari = isset($_GET['cari']) ? $_GET['cari'] : "";
$sparql = <<< END
PREFIX mongoDB: <http://www.semanticweb.org/benz/ontologies/2019/10/mongoDB#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

SELECT DISTINCT *
{
 {
  ?s ?p ?o.
     FILTER REGEX(?o, "$cari", "i" ) 
  }
  union
  {
	?s ?p ?o.
 FILTER(regex(str(?p), "$cari", "i" ) )
  }
  union
  {
	?s rdf:type ?o.
 FILTER(regex(str(?o), "$cari", "i" ) )
  }
 union
  {
	?s rdf:type ?o.
 FILTER(regex(str(?s), "$cari", "i" ) )
  }
}
ORDER BY ?s

END;

$url = 'http://localhost:3030/mongoDB/query?query=' . urlencode($sparql);
$res = \Httpful\Request::get($url)->expectsJson()->send();
$arr = json_decode($res);
?>

<html lang="en" >

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <title>Document</title>
</head>

<?php
  require_once "header.php";
?>


<body >  
  <h4 class=" text-center">SEARCH DATA <small>(tidak termasuk kelas)</small></h4>
  <nav class="navbar navbar-light m-2 justify-content-center">
    <form class="form-inline">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="cari" value="<?php echo isset($_GET['cari']) ? $_GET['cari'] : ''; ?>">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </nav>
  <table class="table table-striped  font-weight-bold">
    <thead>
      <tr>
        <th> Subject</>
        <th> Predikat</>
        <th> Object</>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($arr->results->bindings as $data) {
        echo "<tr>";
        echo "<td>", str_replace($mongoDB, $replace, $data->s->value), "</td>", "<td>", isset($data->p->value) ? str_replace($mongoDB, $replace, $data->p->value) : "rdf:type", "</td>", "<td>", str_replace($mongoDB, $replace, $data->o->value),
          "</td>";
        echo  "</tr>";
      }
      ?>
    </tbody>
  </table>
</body>





</html>