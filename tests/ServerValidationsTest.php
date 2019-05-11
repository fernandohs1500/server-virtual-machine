<?php

use PHPUnit\Framework\TestCase;

use service\ServerCalculateService;
use model\VirtualMachines;
use service\ServerCheckerService;
use model\Server;

final class ServerValidationsTest extends TestCase
{
    protected $serverJson;

    protected function setUp()
    {
        $this->serverJson = '{"CPU": 2, "RAM": 32, "HDD": 100}';
    }

    public function testServerWithoutVirtualMachine()
    {
        $listVirtualMachines = '[]';

        $this->expectException(\exception\ValidationException::class);

        $service = new ServerCalculateService(
            new VirtualMachines($listVirtualMachines),
            new ServerCheckerService(new Server($this->serverJson))
        );

        $service->calculate();
    }

    public function testVirtualMachineWithoutOneParameter()
    {
        $listVirtualMachines = '[{"CPU": 1, "RAM": 16, "HDD": 10}, {"CPU": 2, "HDD": 100}]';

        $this->expectException(\exception\ValidationException::class);

        $service = new ServerCalculateService(
            new VirtualMachines($listVirtualMachines),
            new ServerCheckerService(new Server($this->serverJson))
        );

        $service->calculate();
    }

    public function testServerWithoutOneParameter()
    {
        $listVirtualMachines = '[{"CPU": 1, "RAM": 16, "HDD": 10}, {"CPU": 2, "RAM": 32, "HDD": 100}]';
        $this->serverJson = '{"CPU": 2, "RAM": 32}';

        $this->expectException(\exception\ValidationException::class);

        $service = new ServerCalculateService(
            new VirtualMachines($listVirtualMachines),
            new ServerCheckerService(new Server($this->serverJson))
        );

        $service->calculate();
    }

    public function testVirtualMachineBiggerThanServer()
    {
        $listVirtualMachines = '[{"CPU": 1, "RAM": 64, "HDD": 10}, {"CPU": 1, "RAM": 16, "HDD": 10}]';

        $this->expectException(\exception\CalculateException::class);

        $service = new ServerCalculateService(
            new VirtualMachines($listVirtualMachines),
            new ServerCheckerService(new Server($this->serverJson))
        );

        $service->calculate();
    }

    public function testAllVirtualMachinesBiggerThanServer()
    {
        $listVirtualMachines =
            '[{"CPU": 1, "RAM": 64, "HDD": 10}, {"CPU": 1, "RAM": 64, "HDD": 10}, {"CPU": 1, "RAM": 64, "HDD": 10}]';

        $this->expectException(\exception\CalculateException::class);

        $service = new ServerCalculateService(
            new VirtualMachines($listVirtualMachines),
            new ServerCheckerService(new Server($this->serverJson))
        );

        $service->calculate();
    }

    public function testVirtualMachineRamBiggerThanServerLimit()
    {
        $listVirtualMachines =
            '[{"CPU": 1, "RAM": 64, "HDD": 10}, {"CPU": 1, "RAM": 640, "HDD": 10}]';

        $this->expectException(\exception\CalculateException::class);

        $service = new ServerCalculateService(
            new VirtualMachines($listVirtualMachines),
            new ServerCheckerService(new Server($this->serverJson))
        );

        $service->calculate();
    }

    public function testVirtualMachineHDDBiggerThanServerLimit()
    {
        $listVirtualMachines =
            '[{"CPU": 1, "RAM": 64, "HDD": 10}, {"CPU": 1, "RAM": 64, "HDD": 100}]';

        $this->expectException(\exception\CalculateException::class);

        $service = new ServerCalculateService(
            new VirtualMachines($listVirtualMachines),
            new ServerCheckerService(new Server($this->serverJson))
        );

        $service->calculate();
    }

}
