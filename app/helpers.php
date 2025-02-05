<?php

use Framework\Config\Config;
use Framework\Core\Container;
use Framework\Views\View;
use Laminas\Diactoros\Response;
use League\Route\Router;

function app(string $abstract)
{
    return Container::getInstance()->get($abstract);
}

function view(string $view, array $data = []): Response
{
    $response = new Response();

    $response->getBody()->write(
        app(View::class)->render($view, $data)
    );

    return $response;
}

function config(string $key, $default = null)
{
    return app(Config::class)->get($key, $default);
}

function route(string $name, array $arguments = [])
{
    return app(Router::class)->getNamedRoute($name)->getPath($arguments);
}

function vite(): string
{
    $devServerIsRunning = false;

    $ch = curl_init("http://localhost:5173/@vite/client");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        return '
            <script type="module" src="http://localhost:5173/@vite/client"></script>
            <script type="module" src="http://localhost:5173/resources/js/app.js"></script>
        ';
    }

    // Aktualizacja ścieżki do manifestu
    $manifestPath = __DIR__ . '/../public/build/.vite/manifest.json';

    if (!file_exists($manifestPath)) {
        throw new RuntimeException(
            'Manifest Vite nie został znaleziony. ' .
            'Uruchom najpierw "npm run build" lub "npm run dev"!'
        );
    }

    $manifest = json_decode(file_get_contents($manifestPath), true);

    // Dostosowanie do nowej struktury manifestu
    if (!isset($manifest['resources/js/app.js'])) {
        throw new RuntimeException(
            'Entry point "resources/js/app.js" nie został znaleziony w manifeście Vite.'
        );
    }

    $entry = $manifest['resources/js/app.js'];

    $html = '<script type="module" src="/build/assets/' . $entry['file'] . '"></script>';

    if (isset($entry['css']) && is_array($entry['css'])) {
        foreach ($entry['css'] as $css) {
            $html .= '<link rel="stylesheet" href="/build/assets/' . $css . '">';
        }
    }

    return $html;
}
