<?php
/**
 * Created by PhpStorm.
 * User: dsamotoy
 * Date: 18.11.19
 * Time: 14:29
 */

namespace Integration\Service;


class General
{
    /** @var array */
    protected $integration;

    /** @var resource */
    protected $curl;

    protected $response;

    public function __construct()
    {
        $this->curl = curl_init();
    }

    public function setTask($Task)
    {
        $this->integration = $Task['integration'];
    }

    public function getResult()
    {
        $this->response = curl_exec($this->curl);

        curl_close($this->curl);

        return json_decode($this->response);
    }
}
