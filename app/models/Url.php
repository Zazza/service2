<?php
/**
 * Created by PhpStorm.
 * User: dsamotoy
 * Date: 17.01.20
 * Time: 15:36
 */
namespace Models;

class Url extends \Phalcon\Mvc\Model
{
    /** @var int */
    public $id;

    /** @var string */
    public $url;

    /** @var string */
    public $assign;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {

    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'url';
    }
}
