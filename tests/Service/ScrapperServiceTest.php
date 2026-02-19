<?php

namespace App\Tests\Service;

use App\Services\ScrapperService;
use PHPUnit\Framework\TestCase;

class ScrapperServiceTest extends TestCase
{
    public function test_fixLinksPhpBase()
    {
        $content = [
            '<base href>',
            '<base 123>',
            '<base class="fdjakl" href="fdja;">',
        ];

        $service = new ScrapperService();
        foreach ($content as $link) {
            $this->assertSame('', $service->fixLinksPhp($link));
        }
    }

    public function test_fixLinksPhpCached()
    {
        $service = new ScrapperService();
        $link = '<link rel="stylesheet" type="text/css" href="/cached.php?t=1756715876&amp;f=/fonts/Fira/fira.css" media="screen">';
        $linkFixed = '<link rel="stylesheet" type="text/css" href="/_external/php.net/cached.php?t=1756715876&amp;f=/fonts/Fira/fira.css" media="screen">';

        $this->assertEquals($linkFixed, $service->fixLinksPhp($link));
    }

    public function test_fixLinksPhpImages()
    {
        $service = new ScrapperService();
        $link = '<img
            src="/images/logos/php-logo-white.svg"
            aria-hidden="true"
            width="80"
            height="40"
          >';
        $linkFixed = '<img
            src="/_external/php.net/images/logos/php-logo-white.svg"
            aria-hidden="true"
            width="80"
            height="40"
          >';

        $this->assertEquals($linkFixed, $service->fixLinksPhp($link));
    }

    public function testFixLinksPhpKeepsHtml(): void
    {
        $service = new ScrapperService();
        $html = '<html lang="aa"><div>Hello</div><p>test</p></html>';
        $this->assertSame($html, $service->fixLinksPhp($html));
    }

    public function test_fixLinksSymfony()
    {
        $service = new ScrapperService();
        $link = '<link rel="preconnect" href="https://connect.symfony.com">';
        $linkFixed = '<link rel="preconnect" href="/_external/connect.symfony.com">';

        $this->assertEquals($linkFixed, $service->fixLinksSymfony($link));
    }

    public function testFixLinksSymfonyKeepsHtml(): void
    {
        $service = new ScrapperService();
        $html = '<html lang="aa"><div>Hello</div><p>test</p></html>';
        $this->assertSame($html, $service->fixLinksSymfony($html));
    }

    public function test_getContentType()
    {
        $service = new ScrapperService();
        $listContentType = [
            'text/javascript' => 'http://sym.freemobile.local/_external/assets/home-L0byq_8.js',
            'text/css' => 'http://sym.freemobile.local/_external/assets/styles/app-rlUvz2c.css',
            'image/svg+xml' => '/favicons/favicon.svg',
            'image/webp' => 'http://sym.freemobile.local/assets/icons/logos/sf-20years-square-r4vNnIC.webp',
            'text/plain' => 'php.net',
        ];

        foreach ($listContentType as $key => $file) {
            $this->assertSame($key, $service->getContentType($file));
        }
    }

}
