<?php

use ArtARTs36\Str\Str;

require 'vendor/autoload.php';

$slug = $_SERVER['argv'][1] ?? null;

if ($slug === null) {
    echo "You must enter correct name" . PHP_EOL;

    return 1;
}

$slug = strtolower($slug);

$words = Str::make($slug)->explode('-');
$title = $words->map('ucwords')->implode('');

if ($words->count() > 1) {
    $namespace = $words->map('ucwords')->slice(0, -1)->implode('\\');
} else {
    $namespace = $title;
}

$namespace = 'CmdWrapper\\Wrapper\\' . $namespace;
$testsNamespace = $namespace . '\\Tests\\';
$packageName = "cmd-wrapper/$slug";

$composer = json_decode(file_get_contents('composer.json'), true);
$composer['name'] = $packageName;
$composer['autoload']['psr-4'] = [
    $namespace . '\\' => 'src/',
];
$composer['autoload-dev']['psr-4'] = [
    $testsNamespace => 'src/',
];

file_put_contents('composer.json', json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

unlink(__FILE__);

$className = $words->last()->upFirstSymbol();

rename(
    __DIR__ . '/src/Example.php',
    $classPath = __DIR__ . '/src/' . $className->append('.php')
);

file_put_contents(
    $classPath,
    str_replace(
        ['class Example', 'namespace CmdWrapper\Wrapper'],
        ['class '. $className, 'namespace ' . $namespace],
        file_get_contents($classPath)
    )
);
