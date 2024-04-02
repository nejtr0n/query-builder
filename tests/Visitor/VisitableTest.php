<?php declare(strict_types=1);

namespace Builder\Tests\Visitor;

use BadMethodCallException;
use Builder\Visitor\Visitable;
use PHPUnit\Framework\TestCase;

class VisitableTest extends TestCase
{
    public function testGetVisitorFails()
    {
        $object = new class() {
            use Visitable;
        };
        $this->expectException(BadMethodCallException::class);
        $object->getVisitor();
    }
}
