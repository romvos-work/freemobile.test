<?php

namespace App\Tests\Service;


use App\Services\ScrapperService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ScrapperServiceIntegrationTest extends KernelTestCase
{
    public function test_ScrapperService()
    {
        self::bootKernel();
        $this->assertInstanceOf(
            ScrapperService::class,
            static::getContainer()->get(ScrapperService::class)
        );
    }
}
