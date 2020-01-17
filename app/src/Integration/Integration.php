<?php
/**
 * Created by PhpStorm.
 * User: dsamotoy
 * Date: 18.11.19
 * Time: 13:39
 */
namespace Integration;

use Integration\Exception\IntegrationNotFoundException;
use Integration\Exception\IntegrationValidateException;
use Integration\Service\Mailchimp;
use Integration\Service\Mailerlite;

class Integration
{
    public static function getInstance($Task)
    {
        if (!self::validate($Task)) {
            throw new IntegrationValidateException();
        }

        switch ($Task['integration']['service']) {
            case Mailerlite::NAME:
                $Instance = new Mailerlite();
                break;
            case Mailchimp::NAME:
                $Instance = new Mailchimp();
                break;
            //case '':
            // ...
            //    break;
            default:
                throw new IntegrationNotFoundException();
        }

        $Instance->setTask($Task);
        return $Instance;
    }

    /**
     * @param $Task
     * @return bool
     */
    private static function validate($Task)
    {
        if (!array_key_exists('integration', $Task)) {
            return false;
        }
        if (!array_key_exists('service', $Task['integration'])) {
            return false;
        }

        return true;
    }
}
