<?php
namespace model;

use exception\ValidationException;

class VirtualMachine
{
    private $cpu;
    private $ram;
    private $hdd;

    public function __construct(Array $server)
    {
        if (empty($server['CPU']) || empty($server['RAM']) || empty($server['HDD'])) {
            throw new ValidationException("You must have to put: CPU, RAM, HDD");
        }

        $this->setCpu($server['CPU']);
        $this->setRam($server['RAM']);
        $this->setHdd($server['HDD']);
    }

    /**
     * @return int
     */
    public function getCpu()
    {
        return $this->cpu;
    }

    /**
     * @param int $cpu
     */
    public function setCpu(int $cpu)
    {
        $this->cpu = $cpu;
    }

    /**
     * @return int
     */
    public function getRam()
    {
        return $this->ram;
    }

    /**
     * @param int $ram
     */
    public function setRam(int $ram)
    {
        $this->ram = $ram;
    }

    /**
     * @return int
     */
    public function getHdd()
    {
        return $this->hdd;
    }

    /**
     * @param int $hdd
     */
    public function setHdd(int $hdd)
    {
        $this->hdd = $hdd;
    }

}