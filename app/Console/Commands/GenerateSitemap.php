<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate XML sitemap for SEO';

    public function handle()
    {
        $baseUrl = config('app.url');
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Homepage
        $xml .= $this->urlElement($baseUrl, '1.0', 'daily');
        
        // Products page
        $xml .= $this->urlElement($baseUrl . '/products', '0.8', 'weekly');

        // Products
        $products = Product::where('status', 'active')->get();
        foreach ($products as $product) {
            $xml .= $this->urlElement(
                $baseUrl . '/products/' . $product->slug,
                '0.7',
                'weekly',
                $product->updated_at
            );
        }

        // Categories
        $categories = Category::where('is_active', true)->get();
        foreach ($categories as $category) {
            $xml .= $this->urlElement(
                $baseUrl . '/categories/' . $category->slug,
                '0.6',
                'monthly',
                $category->updated_at
            );
        }

        $xml .= '</urlset>';

        File::put(public_path('sitemap.xml'), $xml);

        $this->info('Sitemap generated successfully at: ' . public_path('sitemap.xml'));
        return Command::SUCCESS;
    }

    private function urlElement(string $url, string $priority, string $changefreq, $lastmod = null): string
    {
        $lastmod = $lastmod ? date('Y-m-d', strtotime($lastmod)) : date('Y-m-d');
        
        return "  <url>\n" .
               "    <loc>{$url}</loc>\n" .
               "    <lastmod>{$lastmod}</lastmod>\n" .
               "    <changefreq>{$changefreq}</changefreq>\n" .
               "    <priority>{$priority}</priority>\n" .
               "  </url>\n";
    }
}
