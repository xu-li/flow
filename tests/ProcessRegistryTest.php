<?php
namespace Xu\Flow\Tests;

use PHPUnit\Framework\TestCase;
use Xu\Flow\ProcessInterface;
use Xu\Flow\ProcessRegistry;

class ProcessRegistryTest extends TestCase
{
    public function testAdd()
    {
        $registry = new ProcessRegistry;

        $process1 = $this->createMock(ProcessInterface::class);
        $process2 = $this->createMock(ProcessInterface::class);

        $registry->add($process1, 0)->add($process2, 10);

        // assertions
        $this->assertEquals(2, count($registry->getProcesses()));
        $this->assertEquals($process2, current($registry->getProcesses()));
    }

    public function testGet()
    {
        $registry = new ProcessRegistry;

        $look_for_item_process = $this->createMock(ProcessInterface::class);
        $look_for_item_process->method('supports')->willReturn(false);

        $stop_looking_process  = $this->createMock(ProcessInterface::class);
        $stop_looking_process->method('supports')->willReturn(true);

        $registry->add([$look_for_item_process, $stop_looking_process]);

        // assertions
        $this->assertEquals($stop_looking_process, $registry->get('stop_looking'));
    }
}
