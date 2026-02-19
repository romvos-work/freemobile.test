<?php
namespace App\Controller;

use App\Services\ScrapperService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController
{

    #[Route('/_external/{host}/{path}', requirements: ['path' => '.*'])]
    public function external(
        string $host,
        string $path,
        Request $request,
        ScrapperService $service
    ): Response {

        // sym
        if ($host == 'assets') {
            $host = 'symfony.com/assets';
        }

        //php
        if ($path == 'cached.php') {
            $path = preg_replace('/\/_external\/php\.net/', '', $request->getRequestUri());
            $host = 'php.net';
        }

        $response = $service->scrap("https://$host/$path");

        return new Response($response->getContent(), 200, [
            'Content-Type' => $service->getContentType($path),
        ]);
    }

    #[Route('/{path}', name: 'index', requirements: ['path' => '.*'])]
    public function index(
        string $path,
        Request $request,
        ScrapperService $service
    ) {
        $domain = $_ENV['APP_TARGET_DOMAIN'] ?? $request->headers->get('x-test-request');

        $page = $service->scrap("https://$domain/$path");
        $content = match ($domain) {
            'symfony.com' => $service->fixLinksSymfony($page->getContent()),
            'php.net' => $service->fixLinksPhp($page->getContent()),
            default => throw new BadRequestHttpException('wrong domain'),
        };

        return new Response($content);
    }

}
