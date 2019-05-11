<?php
namespace model;

use exception\ValidationException;

class VirtualMachines
{
    private $lstVirtualMachines = array();

    public function __construct(String $virtualMachines)
    {
        $virtualMachines = json_decode($virtualMachines, true);

        if (empty($virtualMachines)) {
            throw new ValidationException("Empty virtual machines!");
        }

        foreach ($virtualMachines as $virtualMachine) {
            $this->lstVirtualMachines[] = new VirtualMachine($virtualMachine);
        }
    }

    public function getList()
    {
        return $this->lstVirtualMachines;
    }

}