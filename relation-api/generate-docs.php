<?php

require_once 'vendor/autoload.php';

use OpenApi\Generator;
use OpenApi\Annotations as OA;

$templateFile = './openapi-template.json';
$templateJson = json_decode(file_get_contents($templateFile), true);

$openapi = Generator::scan(['src']);

$openapiArray = json_decode($openapi->toJson(), true);

$mergedOpenApi = array_merge_recursive($templateJson, $openapiArray);

file_put_contents('public/openapi.json', json_encode($mergedOpenApi, JSON_PRETTY_PRINT));
