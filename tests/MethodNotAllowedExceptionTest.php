<?php
/**
 * @package   Atanvarno\Router
 * @author    atanvarno69 <https://github.com/atanvarno69>
 * @copyright 2017 atanvarno.com
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Atanvarno\Router\Test;

/** SPL use block. */
use Throwable;

/** HTTP Message Utilities use block. */
use Fig\Http\Message\RequestMethodInterface;

/** PHP Unit use block. */
use PHPUnit\Framework\TestCase;

/** Package use block. */
use Atanvarno\Router\Exception\{
    MethodNotAllowedException, RouterException
};

class MethodNotAllowedExceptionTest extends TestCase
{
    private $exception;

    public function setUp()
    {
        $this->exception = new MethodNotAllowedException(
            [
                RequestMethodInterface::METHOD_GET,
                RequestMethodInterface::METHOD_HEAD,
            ],
            RequestMethodInterface::METHOD_POST
        );
    }

    public function testImplementsRouterException()
    {
        $this->assertInstanceOf(RouterException::class, $this->exception);
    }

    public function testIsThrowable()
    {
        $this->assertInstanceOf(Throwable::class, $this->exception);
    }

    public function testCaught()
    {
        try {
            throw $this->exception;
        } catch (MethodNotAllowedException $caught) {
            $expectedMessage = 'Method POST is not allowed for this route';
            $this->assertSame($expectedMessage, $caught->getMessage());
            $expectedAllowed = [
                RequestMethodInterface::METHOD_GET,
                RequestMethodInterface::METHOD_HEAD
            ];
            $this->assertSame($expectedAllowed, $caught->getAllowed());
        }
    }
}
