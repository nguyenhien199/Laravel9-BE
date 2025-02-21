<?php

namespace App\Console\Commands;

use Spatie\Crawler\Crawler;
use Spatie\Sitemap\SitemapGenerator;

/**
 * Class GenerateSitemap
 *
 * @package App\Console\Commands
 */
class GenerateSitemap extends Core\BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        // Format URL.
        $url = config('sitemap.site_url');
        $url = mb_rtrim($url, '/').'/';

        // Format File path.
        $file = config('sitemap.file_path');

        // Modify this to your own needs.
        SitemapGenerator::create($url)
            ->configureCrawler(function (Crawler $crawler) {
                $crawler->ignoreRobots();
            })
            ->writeToFile($file);
    }
}