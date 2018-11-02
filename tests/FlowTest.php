<?php
namespace Xu\Flow\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Workflow\Definition;
use Symfony\Component\Workflow\DefinitionBuilder;
use Symfony\Component\Workflow\Transition;
use Xu\Flow\Flow;
use Xu\Flow\ProcessInterface;
use Xu\Flow\ProcessNotFoundException;
use Xu\Flow\ProcessRegistry;

class FlowTest extends TestCase
{
    public function testProceedEmptyFlow()
    {
        $definition = (new DefinitionBuilder())->build();
        $registry = $this->createMock(ProcessRegistry::class);

        $flow = new Flow($definition, $registry);
        $flow->proceed();

        // assert empty
        $this->assertNull($flow->getState());
    }

    public function testProceedMissingProcess()
    {
        $this->expectException(ProcessNotFoundException::class);

        $definition = (new DefinitionBuilder())->addPlaces(['look_for_lost_item'])->build();
        $registry = $this->createMock(ProcessRegistry::class);

        $flow = new Flow($definition, $registry);
        $flow->proceed();
    }

    public function testProceed()
    {
        $definition = (new DefinitionBuilder())->addPlaces([
                'look_for_lost_item',
                'did_you_find_it',
                'stop_looking'
            ])

            // Transitions are defined with a unique name, an origin place and a destination place
            ->addTransition(new Transition('to-did_you_find_it', 'look_for_lost_item', 'did_you_find_it'))
            ->addTransition(new Transition('yes-did_you_find_it', 'did_you_find_it', 'stop_looking'))
            ->addTransition(new Transition('no-did_you_find_it', 'did_you_find_it', 'look_for_lost_item'))

            ->build();

        $process = $this->createMock(ProcessInterface::class);
        $process->method('supports')->willReturn(true);
        $process->method('proceed')->willReturn(true);

        $registry = $this->createMock(ProcessRegistry::class);
        $registry->method('get')->willReturn($process);

        $flow = new Flow($definition, $registry);
        $flow->proceed();

        // assertions
        $this->assertEquals('stop_looking', $flow->getState());
    }
}
