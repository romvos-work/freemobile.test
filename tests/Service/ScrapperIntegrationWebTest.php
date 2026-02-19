<?php

namespace App\Tests\Service;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ScrapperIntegrationWebTest extends WebTestCase
{
    public function test_ScrapperPagePhp()
    {
        $client = static::createClient();
        $client->request('GET', 'http://php.freemobile.local/docs.php',
            [],
            [],
            ['HTTP_X_TEST_REQUEST' => 'php.net']
        );

        $this->assertResponseStatusCodeSame(200);
    }

    public function test_ScrapperPagePhpExternal()
    {
        $client = static::createClient();
        $client->request('GET', 'http://php.freemobile.local/_external/php.net/cached.php?t=1756715876&f=/js/ext/FuzzySearch.min.js',
            [],
            [],
            ['HTTP_X_TEST_REQUEST' => 'php.net']
        );

        $this->assertResponseStatusCodeSame(200);
    }

    public function test_ScrapperPageSymfony()
    {
        $client = static::createClient();
        $client->request('GET', 'http://sym.freemobile.local',
            [],
            [],
            ['HTTP_X_TEST_REQUEST' => 'symfony.com']
        );

        $this->assertResponseHasHeader('Content-Type', 'application/javascript');
        $this->assertResponseStatusCodeSame(200);
    }

    public function test_ScrapperPageSymfonyExternal()
    {
        $client = static::createClient();
        $client->request('GET', 'http://sym.freemobile.local/_external/assets/app-iodFN2G.js',
            [],
            [],
            ['HTTP_X_TEST_REQUEST' => 'symfony.com']
        );

        $this->assertResponseHasHeader('Content-Type', 'application/javascript');
        $this->assertResponseStatusCodeSame(200);
    }
}
