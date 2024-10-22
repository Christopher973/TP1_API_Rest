<?php
require("vendor/autoload.php");

$openapi = \OpenApi\Generator::scan([__DIR__ . '/api', __DIR__ . '/modele']);

header('Content-Type: application/x-yaml');
echo $openapi->toYaml();