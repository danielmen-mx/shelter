<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Faker\Generator;

abstract class TestCase extends BaseTestCase
{
    protected $faker;

    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = $this->withFaker();
    }

    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }

    protected function createNames()
    {
        return Str::slug($this->faker->firstName);
    }

    protected function createLastNames()
    {
        return Str::slug($this->faker->lastName);
    }

    protected function createRequest(string $method, array $attributes): Request
    {
        $request = new \Illuminate\Http\Request();
        $request->setMethod($method);
        collect($attributes)->each(function ($value, $key) use (&$request) {
            $request->request->add([$key => $value]);
        });

        return $request;
    }
}
