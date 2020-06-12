<?php


namespace Iyngaran\ApiResponse\Tests\Unit\Domain\RealEstate;


use Illuminate\Http\Resources\Json\JsonResource;
use Iyngaran\ApiResponse\Http\Traits\ApiResponse;
use Orchestra\Testbench\TestCase;

class SimpleTest extends TestCase
{
    use ApiResponse;

    /** @test */
    public function a_simple_test()
    {
        $objJsonResource = new JsonResource(['test'=>'112']);
        $response = $this->responseWithItem($objJsonResource);
        $this->assertTrue(true);
    }
}