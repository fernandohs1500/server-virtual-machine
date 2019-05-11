<?php

namespace service;

use model\Server;
use model\VirtualMachine;

class ServerCheckerService implements IServerCheckerService
{
    private $server;

    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    public function checkServerLimit($cpuNewValue, $ramNewValue, $hdNewValue)
    {
        if ($cpuNewValue > $this->server->getCpu() ||
            $ramNewValue > $this->server->getRam() ||
            $hdNewValue > $this->server->getHdd()) {
            return false;
        }
        return true;
    }

    public function checkIfVirtualMachineIsBiggerThanServer(VirtualMachine $virtualMachine)
    {
        if (
            $virtualMachine->getHdd() > $this->server->getHdd() ||
            $virtualMachine->getRam() > $this->server->getRam() ||
            $virtualMachine->getCpu() > $this->server->getCpu()
        ) {
            return true;
        }
        return false;
    }

}
