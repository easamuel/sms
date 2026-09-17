<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeoController extends Controller
{
    /**
     * Generate dynamic XML sitemap for search engines and AI bots
     */
    public function sitemap()
    {
        $baseUrl = url('/');
        
        $urls = [
            [
                'loc' => $baseUrl,
                'lastmod' => now()->format('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '1.0'
            ],
            [
                'loc' => $baseUrl . '/admission',
                'lastmod' => now()->format('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '0.95'
            ],
            [
                'loc' => $baseUrl . '/school-management/demo-login',
                'lastmod' => now()->format('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.90'
            ],
            [
                'loc' => $baseUrl . '/contact',
                'lastmod' => now()->format('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.85'
            ],
            [
                'loc' => $baseUrl . '/privacy-policy',
                'lastmod' => now()->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.50'
            ],
            [
                'loc' => $baseUrl . '/terms-of-service',
                'lastmod' => now()->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.50'
            ],
            [
                'loc' => $baseUrl . '/cookie-policy',
                'lastmod' => now()->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.50'
            ],
        ];
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        foreach ($urls as $url) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . htmlspecialchars($url['loc']) . '</loc>' . "\n";
            $xml .= '    <lastmod>' . $url['lastmod'] . '</lastmod>' . "\n";
            $xml .= '    <changefreq>' . $url['changefreq'] . '</changefreq>' . "\n";
            $xml .= '    <priority>' . $url['priority'] . '</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }
        
        $xml .= '</urlset>';
        
        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }
    
    /**
     * Generate robots.txt allowing all web search and AI crawlers
     */
    public function robots()
    {
        $robots = "# Robots.txt for ES-SCHOOLS (ExtremeSolutions SMS)\n";
        $robots .= "User-agent: *\n";
        $robots .= "Allow: /\n";
        $robots .= "Disallow: /sms/logout\n";
        $robots .= "Disallow: /logout\n";
        $robots .= "Disallow: /school-management/authorized-login\n\n";

        $aiBots = [
            'Googlebot',
            'Google-Extended',
            'Bingbot',
            'GPTBot',
            'ChatGPT-User',
            'ClaudeBot',
            'Claude-Web',
            'anthropic-ai',
            'PerplexityBot',
            'Applebot',
            'Applebot-Extended',
            'CCBot',
            'cohere-ai',
            'Meta-ExternalAgent',
            'Bytespider',
            'Amazonbot',
        ];

        foreach ($aiBots as $bot) {
            $robots .= "User-agent: {$bot}\n";
            $robots .= "Allow: /\n\n";
        }
        
        $robots .= "Sitemap: " . url('/sitemap.xml') . "\n";
        
        return response($robots, 200)
            ->header('Content-Type', 'text/plain');
    }
}
