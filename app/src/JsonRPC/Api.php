<?php
/**
 * Created by PhpStorm.
 * User: dsamotoy
 * Date: 17.01.20
 * Time: 14:37
 */
namespace App\JsonRPC;

use Datto\JsonRpc\Evaluator;
use Datto\JsonRpc\Exceptions\ApplicationException;
use Phalcon\DispatcherInterface;
use function count;

class Api implements Evaluator
{
    /**
     * @var DispatcherInterface
     */
    private $dispatcher;

    public function __construct(DispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @return DispatcherInterface
     */
    private function getDispatcher(): DispatcherInterface
    {
        return $this->dispatcher;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return array
     * @throws ApplicationException
     */
    public function evaluate($method, $arguments): array
    {
        $this->validateControllerAndAction($method);
        $this->getDispatcher()->forward($this->getControllerAndAction($method));
        $this->getDispatcher()->setParams($arguments);
        try {
            $this->getDispatcher()->dispatch();
        } catch (\Throwable $e) {
            throw new ApplicationException($e->getMessage(), $e->getCode());
        }
        return $this->getDispatcher()->getReturnedValue();
    }

    /**
     * @param string $method
     * @throws ApplicationException
     */
    private function validateControllerAndAction(string $method): void
    {
        $methodAndController = explode('.', $method);
        if (count($methodAndController) !== 2) {
            throw new ApplicationException(
                'Invalid controller and action name, need use `controllerName.actionName`',
                $CODE = 1
            );
        }
    }

    private function getControllerAndAction(string $method): array
    {
        $methodAndController = explode('.', $method);

        return [
            'controller' => ucfirst($methodAndController[0]),
            'action' => $methodAndController[1],
        ];
    }
}
