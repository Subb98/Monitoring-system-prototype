<?php

declare(strict_types=1);

$start = microtime(true);

require_once __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Exception\ConnectException;
use InfluxDB2\{Client, Model\WritePrecision, Point};

$token = getenv('DOCKER_INFLUXDB_INIT_ADMIN_TOKEN');
$org = getenv('DOCKER_INFLUXDB_INIT_ORG');
$bucket = getenv('DOCKER_INFLUXDB_INIT_BUCKET');

$client = new Client([
    'url' => 'http://influxdb:8086',
    'token' => $token,
    'org' => $org,
    'bucket' => $bucket,
    'precision' => WritePrecision::S,
]);

try {
    $client->ping();
} catch (ConnectException $e) {
    exit("Failed to connect to InfluxDB Server; code: {$e->getCode()}, message: {$e->getMessage()}\n");
}

sleep(mt_rand(1, 5));
$diff = microtime(true) - $start;

$point = Point::measurement('php-metrics')
    ->addTag('location', 'php-metrics')
    ->addField('handle-time', $diff)
    ->time(time())
    ;

$writeApi = $client->createWriteApi();
$writeApi->write($point, WritePrecision::S, $bucket, $org);
