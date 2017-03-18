<?php

namespace seregazhuk\tests\Bot\Api;

use Mockery;
use PHPUnit_Framework_TestCase;
use seregazhuk\PinterestBot\Api\Request;
use seregazhuk\PinterestBot\Api\Response;
use seregazhuk\PinterestBot\Api\Providers\Core\Provider;

/**
 * Class ProviderTest.
 */
class ProviderTest extends PHPUnit_Framework_TestCase
{

    protected function tearDown()
    {
        Mockery::close();
    }

    /** @test */
    public function it_returns_data_for_response()
    {
        $response = ['resource_response' => ['data' => 'value']];

        $provider = $this->makeProvider($response);

        $responseData = $response['resource_response']['data'];

        $this->assertEquals($responseData, $provider->visitPage());
    }

    /**
     * @param $response
     * @return Mockery\Mock|Provider
     */
    protected function makeProvider($response)
    {
        $request = Mockery::mock(Request::class)
            ->shouldReceive('exec')
            ->andReturn(json_encode($response))
            ->getMock();

        return Mockery::mock(Provider::class, [$request, new Response()])
            ->makePartial();
    }
}