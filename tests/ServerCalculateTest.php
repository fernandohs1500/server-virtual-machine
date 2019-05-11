<?php

use PHPUnit\Framework\TestCase;

use service\ServerCalculateService;
use model\VirtualMachines;
use service\ServerCheckerService;
use model\Server;

final class ServerCalculateTest extends TestCase
{
    protected $serverJson;

    protected function setUp()
    {
        $this->serverJson = '{"CPU": 2, "RAM": 32, "HDD": 100}';
    }

    public function testOneVirtualMachine()
    {
        $listVirtualMachines =
            '[{"CPU": 1, "RAM": 16, "HDD": 10}]';

        $service = new ServerCalculateService(
            new VirtualMachines($listVirtualMachines),
            new ServerCheckerService(new Server($this->serverJson))
        );

        $numberServers = $service->calculate();

        $this->assertEquals($numberServers, 1);
    }

    public function testTwoVirtualMachineWithSameSize()
    {
        $listVirtualMachines =
            '[{"CPU": 1, "RAM": 32, "HDD": 10}, {"CPU": 1, "RAM": 32, "HDD": 10}]';

        $service = new ServerCalculateService(
            new VirtualMachines($listVirtualMachines),
            new ServerCheckerService(new Server($this->serverJson))
        );

        $numberServers = $service->calculate();

        $this->assertEquals($numberServers, 2);
    }

    public function testThreeOrMoreVirtualMachineWithDistinctSize()
    {
        $listVirtualMachines =
            '[{"CPU": 1, "RAM": 32, "HDD": 10}, {"CPU": 1, "RAM": 18, "HDD": 10}, 
            {"CPU": 1, "RAM": 18, "HDD": 10}, {"CPU": 1, "RAM": 18, "HDD": 10}]';

        $service = new ServerCalculateService(
            new VirtualMachines($listVirtualMachines),
            new ServerCheckerService(new Server($this->serverJson))
        );

        $numberServers = $service->calculate();

        $this->assertEquals($numberServers, 4);
    }

    public function testFirstVirtualMachineTheBiggest()
    {
        $listVirtualMachines =
            '[{"CPU": 1, "RAM": 32, "HDD": 10}, {"CPU": 1, "RAM": 16, "HDD": 10}, {"CPU": 1, "RAM": 16, "HDD": 10}]';

        $service = new ServerCalculateService(
            new VirtualMachines($listVirtualMachines),
            new ServerCheckerService(new Server($this->serverJson))
        );

        $numberServers = $service->calculate();

        $this->assertEquals($numberServers, 2);
    }

    public function testMiddleVirtualMachineTheBiggest()
    {
        $listVirtualMachines =
            '[{"CPU": 1, "RAM": 16, "HDD": 10}, {"CPU": 1, "RAM": 32, "HDD": 10}, {"CPU": 1, "RAM": 16, "HDD": 10}]';

        $service = new ServerCalculateService(
            new VirtualMachines($listVirtualMachines),
            new ServerCheckerService(new Server($this->serverJson))
        );

        $numberServers = $service->calculate();

        $this->assertEquals($numberServers, 3);
    }

    public function testLastVirtualMachineTheBiggest()
    {
        $listVirtualMachines =
            '[{"CPU": 1, "RAM": 16, "HDD": 10}, {"CPU": 1, "RAM": 16, "HDD": 10}, {"CPU": 1, "RAM": 32, "HDD": 10}]';

        $service = new ServerCalculateService(
            new VirtualMachines($listVirtualMachines),
            new ServerCheckerService(new Server($this->serverJson))
        );

        $numberServers = $service->calculate();

        $this->assertEquals($numberServers, 2);
    }

}
