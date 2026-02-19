<?php

namespace App\Services;


use Symfony\Component\HttpClient\CurlHttpClient;

class ScrapperService
{
    protected $client;

    public function __construct(
        CurlHttpClient $client = null
    ) {
        $this->client = empty($client)
            ? new CurlHttpClient()
            : $client;
    }

    /**
     * @param string $url
     * @param $origin
     * @return \Symfony\Contracts\HttpClient\ResponseInterface
     */
    public function scrap(string $url)
    {
        return $this->client->request('GET', $url);
    }

    /**
     * @param string $content
     * @return array|string|string[]|null
     */
    public function fixLinksPhp(string $content)
    {
        $content = preg_replace('/<base .+>/', '', $content);
        $content = preg_replace(
            '/\"\/cached/',
            '"/_external/php.net/cached',
            $content
        );
        $content = preg_replace(
            '/\"\/images/',
            "\"/_external/php.net/images",
            $content
        );

        return $content;
    }

    /**
     * @param string $content
     * @return array|string|string[]|null
     */
    public function fixLinksSymfony(string $content)
    {
        $content = preg_replace(
            '/https:\/\/connect\.symfony\.com/',
            '/_external/connect.symfony.com',
            $content
        );
        $content = preg_replace('/href=\"\/assets/', 'href="/_external/assets', $content);

        return $content;
    }

    public function getContentType(string $path)
    {
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $contentType = match ($extension) {
            'js' => 'text/javascript',
            'css' => 'text/css',
            'svg' => 'image/svg+xml',
            'webp' => 'image/webp',
            default => 'text/plain',
        };

        return $contentType;
    }

}
