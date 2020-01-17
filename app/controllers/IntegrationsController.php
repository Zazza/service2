<?php
/**
 * Created by PhpStorm.
 * User: dsamotoy
 * Date: 18.11.19
 * Time: 14:16
 */
namespace Controllers;

use Integration\Exception\IntegrationNotFoundException;
use Integration\Exception\IntegrationValidateException;
use Integration\Integration;
use Phalcon\Mvc\Controller;

class IntegrationsController extends Controller
{
    public function addSubscriberAction()
    {
        $TaskList = $this->request->getPost('Tasks', null, []);
        $name = $this->request->getPost('name', 'striptags', '');
        $email = $this->request->getPost('email', 'striptags', '');

        foreach ($TaskList as $Task) {
            try {
                $Instance = Integration::getInstance($Task);
                $Instance->addSubscriber($name, $email);
            } catch (IntegrationNotFoundException $e) {
                return json_encode(['result' => false, 'comment' => 'Integration not found']);
            } catch (IntegrationValidateException $e) {
                return json_encode(['result' => false, 'comment' => 'Parsing error']);
            }
        }

        return json_encode(['result' => true]);
    }
}
