<?php

include_once __DIR__ . "/../bootstrap.php";

use Xu\Flow\Flow;

$flow = new Flow($definition, $registry);
$flow->proceed((object) ['tried' => 0]);
