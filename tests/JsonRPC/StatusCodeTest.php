<?php
/**
 * Created by PhpStorm.
 * User: dsamotoy
 * Date: 18.01.20
 * Time: 19:07
 */

use Datto\JsonRpc\Client;
use Phalcon\Http\Client\Request as ClientRequest;

class AuthControllerTest extends \PHPUnit\Framework\TestCase
{
    const CLIENT_URL = 'http://client.com';
    const SERVER_URL = 'http://service2.local';

    /**
    Phalcon\Http\Client\Response Object
    (
        [body] => {"jsonrpc":"2.0","id":1,"error":{"code":2,"message":"URL error"}}
        [header] => Phalcon\Http\Client\Header Object
        (
            [fields:Phalcon\Http\Client\Header:private] => Array
            (
                [Server] => nginx/1.15.0
                [Date] => Sat, 18 Jan 2020 16:38:20 GMT
                [Content-Type] => text/html; charset=UTF-8
                [Transfer-Encoding] => chunked
                [Connection] => keep-alive
            )
            [version] => 1.1
            [statusCode] => 200
            [statusMessage] => OK
            [status] => HTTP/1.1 200 OK
         )
    )
    */
    public function testGenerate()
    {
        $data = [
            'url' => 'httpr:///r.r'
        ];
        $client = new Client();
        $client->query(
            $id = 1,
            'url.generate',
            $data
        );
        $body = $client->encode();
        $this->assertEquals($body, '{"jsonrpc":"2.0","method":"url.generate","params":{"url":"httpr:\/\/\/r.r"},"id":1}');

        $provider = ClientRequest::getProvider();
        $provider->setBaseUri(self::CLIENT_URL);
        $provider->header->set('Accept', 'application/json');

        $result = $provider->post(self::SERVER_URL, $body);
        //print_r($result);

        $this->assertEquals($result->header->statusCode, 200);
    }

    /**
    Phalcon\Http\Client\Response Object
    (
        [body] => {"jsonrpc":"2.0","id":1,"error":{"code":5,"message":"Action 'notExistMethod' was not found on handler 'Url'"}}
        [header] => Phalcon\Http\Client\Header Object
        (
            [fields:Phalcon\Http\Client\Header:private] => Array
            (
                [Server] => nginx/1.15.0
                [Date] => Sat, 18 Jan 2020 16:40:56 GMT
                [Content-Type] => text/html; charset=UTF-8
                [Transfer-Encoding] => chunked
                [Connection] => keep-alive
            )
            [version] => 1.1
            [statusCode] => 404
            [statusMessage] => Not Found
            [status] => HTTP/1.1 404 Not Found
        )
    )
     */
    public function testMethodNotFound()
    {
        $data = [];
        $client = new Client();
        $client->query(
            $id = 1,
            'url.notExistMethod',
            $data
        );
        $body = $client->encode();
        $this->assertEquals($body, '{"jsonrpc":"2.0","method":"url.notExistMethod","params":[],"id":1}');

        $provider = ClientRequest::getProvider();
        $provider->setBaseUri(self::CLIENT_URL);
        $provider->header->set('Accept', 'application/json');

        $result = $provider->post(self::SERVER_URL, $body);
        //print_r($result);

        $this->assertEquals($result->header->statusCode, 404);
    }

    /**
    Phalcon\Http\Client\Response Object
    (
        [body] => {"jsonrpc":"2.0","id":1,"error":{"code":-32600,"message":"Invalid Request"}}
        [header] => Phalcon\Http\Client\Header Object
        (
            [fields:Phalcon\Http\Client\Header:private] => Array
            (
                [Server] => nginx/1.15.0
                [Date] => Sat, 18 Jan 2020 16:40:56 GMT
                [Content-Type] => text/html; charset=UTF-8
                [Transfer-Encoding] => chunked
                [Connection] => keep-alive
            )
        [version] => 1.1
        [statusCode] => 200
        [statusMessage] => OK
        [status] => HTTP/1.1 200 OK
        )
    )
     */
    public function testParseError()
    {
        $body = '{"jsonrpc":"2.0","methodi":"url.generate","paraims":[],"id":1}';

        $provider = ClientRequest::getProvider();
        $provider->setBaseUri(self::CLIENT_URL);
        $provider->header->set('Accept', 'application/json');

        $result = $provider->post(self::SERVER_URL, $body);
        //print_r($result);

        $this->assertEquals($result->header->statusCode, -32600);
    }
}
