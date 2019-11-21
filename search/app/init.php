<?php 

require_once "C:/Apache24/htdocs/vendor/autoload.php";

use Elasticsearch\ClientBuilder;
$es = ClientBuilder::create()->setHosts(['localhost:9200'])->build();
 
?>
