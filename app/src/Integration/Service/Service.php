<?php
/**
 * Created by PhpStorm.
 * User: dsamotoy
 * Date: 18.11.19
 * Time: 14:34
 */

namespace Integration\Service;


interface Service
{
    public function createGroup(array $param): bool;
    public function addSubscriber(string $name, string $email): bool;
}
