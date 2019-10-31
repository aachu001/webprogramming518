<?php 

require_once "../vendor/autoload.php";
use Elasticsearch\ClientBuilder;
$es = ClientBuilder::create()->setHosts(['localhost:9200'])->build();
 
?>
