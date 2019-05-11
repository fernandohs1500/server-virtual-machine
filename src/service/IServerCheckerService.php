<?php

namespace service;

use model\VirtualMachine;

interface IServerCheckerService
{
    public function checkServerLimit($cpuNewValue, $ramNewValue, $hdNewValue);
    public function checkIfVirtualMachineIsBiggerThanServer(VirtualMachine $virtualMachine);
}