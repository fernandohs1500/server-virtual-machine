<?php
require "vendor/autoload.php";

use service\ServerCalculateService;
use model\VirtualMachines;
use service\ServerCheckerService;
use model\Server;

$serverTypeJson = '{"CPU": 2, "RAM": 32, "HDD": 100}';
$listVm = '[{"CPU": 1, "RAM": 16, "HDD": 10}, {"CPU": 1, "RAM": 16, "HDD": 10}, {"CPU": 2, "RAM": 32, "HDD": 100}]';

$service = new ServerCalculateService(
    new VirtualMachines($listVm),
    new ServerCheckerService(new Server($serverTypeJson))
);

$numberServers = $service->calculate();

echo "It's necessary {$numberServers} Servers to host all the virtual machines!";