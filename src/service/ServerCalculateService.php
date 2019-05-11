<?php

namespace service;

use exception\CalculateException;
use model\VirtualMachines;

class ServerCalculateService implements IServerCalculateService
{
    private $listVirtualMachine;
    private $checkerServerService;

    public function __construct(VirtualMachines $listVirtualMachine, IServerCheckerService $checkerService)
    {
        $this->listVirtualMachine = $listVirtualMachine;
        $this->checkerServerService = $checkerService;
    }

    public function calculate()
    {
        $serverNumber = 1;
        $cpuSum = 0; $ramSum = 0; $hdSum = 0;

        foreach ($this->listVirtualMachine->getList() as $virtualMachine) {

            if ($this->checkerServerService->checkIfVirtualMachineIsBiggerThanServer($virtualMachine)) {
                throw new CalculateException("Virtual machine is too 'big' for this server!");
            }

            $cpuNewValue = $cpuSum + $virtualMachine->getCpu();
            $ramNewValue = $ramSum + $virtualMachine->getRam();
            $hdNewValue = $hdSum + $virtualMachine->getHdd();

            if (!$this->checkerServerService->checkServerLimit($cpuNewValue, $ramNewValue, $hdNewValue)) {
                $cpuSum = 0; $ramSum = 0; $hdSum = 0;
                $serverNumber++;
            }

            $cpuSum += $virtualMachine->getCpu();
            $ramSum += $virtualMachine->getRam();
            $hdSum += $virtualMachine->getHdd();
        }

        return $serverNumber;
    }
}
