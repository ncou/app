<?php

declare(strict_types=1);

namespace App\Asset;

use Chiron\Assets\AssetBundle;

// TODO : renommer en HomeAsset pour que ce soit en phase avec le nom du HomeController et le nom de la page home.phtml
// TODO : renommer en SiteAsset ????
class AppAsset extends AssetBundle
{
    public ?string $basePath = '@public/assets';
    public ?string $baseUrl = '/assets';
    public ?string $sourcePath = '@resources/assets'; // TODO : améliorer le code avec un normalizePath car si on ajout un '/' ou './' ca fonctionne pas super bien la concaténation doit pas bien marcher !!!!

    public array $css = [
        'css/site.css', // TODO : améliorer le code avec un normalizePath car si on ajout un '/' ou './' ca fonctionne pas super bien la concaténation doit pas bien marcher !!!!
    ];

    // TODO : bloc à virer c'est pour un test !!!
    public array $js = [
        [
            'https://code.jquery.com/jquery-3.4.1.js',
            'integrity' => 'sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=',
            'crossorigin' => 'anonymous',
        ],
    ];
}
