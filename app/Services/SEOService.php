<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Blog;
use App\Models\Service;
use App\Models\Content;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;

class SEOService
{
  
    public function generateMetaTags(string $page, $model = null): array
    {
        
        $siteBrandingContent = Content::where('key', 'site_branding')->first();
        $siteBranding = $siteBrandingContent ? $siteBrandingContent->toArray() : [];

        $siteTitle = $siteBranding['title'] ?? 'Aziz Khan';
        $siteDescription = $siteBranding['content'] ?? 'Professional portfolio showcasing expertise in web development, design, and digital solutions.';
        $siteKeywords = $siteBranding['meta']['meta_keywords'] ?? '2D Artist, 3D Artist, Web Developer, Laravel, 3ds Max, UI/UX Design, Portfolio, Aziz Khan';

        $baseTitle = $siteTitle;
        $baseDescription = $siteDescription;
        $baseKeywords = $siteKeywords;

        switch ($page) {
            case 'home':
                return [
                    'title' => $baseTitle,
                    'description' => $baseDescription,
                    'keywords' => $baseKeywords,
                    'ogType' => 'website',
                    'ogUrl' => url('/'),
                    'ogImage' => asset('images/og-home.jpg'),
                    'canonical' => url('/'),
                    'structuredData' => $this->generatePersonStructuredData()
                ];

            case 'about':
                return [
                    'title' => 'About - ' . $baseTitle,
                    'description' => 'Learn about Aziz Khan\'s background, skills, and experience in 2D/3D art and web development. Download resume and explore professional journey.',
                    'keywords' => $baseKeywords . ', About, Resume, Skills, Experience',
                    'ogType' => 'profile',
                    'ogUrl' => route('about'),
                    'ogImage' => asset('images/og-about.jpg'),
                    'canonical' => route('about'),
                    'structuredData' => $this->generatePersonStructuredData()
                ];

            case 'projects':
                if ($model instanceof Project) {
                    return $this->generateProjectMetaTags($model);
                }
                return [
                    'title' => 'Projects - ' . $baseTitle,
                    'description' => 'Explore Aziz Khan\'s portfolio of web development and 3D art projects. View detailed case studies and technical implementations.',
                    'keywords' => $baseKeywords . ', Projects, Portfolio, Web Development, 3D Art',
                    'ogType' => 'website',
                    'ogUrl' => route('projects.index'),
                    'ogImage' => asset('images/og-projects.jpg'),
                    'canonical' => route('projects.index'),
                    'structuredData' => $this->generateProjectsStructuredData()
                ];

            case 'blog':
                if ($model instanceof Blog) {
                    return $this->generateBlogMetaTags($model);
                }
                return [
                    'title' => 'Blog - ' . $baseTitle,
                    'description' => 'Read insights, tutorials, and thoughts on web development, 3D art, and technology from Aziz Khan.',
                    'keywords' => $baseKeywords . ', Blog, Articles, Tutorials, Insights',
                    'ogType' => 'website',
                    'ogUrl' => route('blog.index'),
                    'ogImage' => asset('images/og-blog.jpg'),
                    'canonical' => route('blog.index'),
                    'structuredData' => $this->generateBlogStructuredData()
                ];

            case 'services':
                return [
                    'title' => 'Services - ' . $baseTitle,
                    'description' => 'Professional services offered by Aziz Khan including web development, 3D modeling, UI/UX design, retopology, rigging, and rendering.',
                    'keywords' => $baseKeywords . ', Services, Web Development, 3D Modeling, UI/UX Design, Retopology, Rigging, Rendering',
                    'ogType' => 'website',
                    'ogUrl' => route('services'),
                    'ogImage' => asset('images/og-services.jpg'),
                    'canonical' => route('services'),
                    'structuredData' => $this->generateServicesStructuredData()
                ];

            case 'testimonials':
                return [
                    'title' => 'Testimonials - ' . $baseTitle,
                    'description' => 'Read what clients and colleagues say about working with Aziz Khan. Professional testimonials and recommendations.',
                    'keywords' => $baseKeywords . ', Testimonials, Reviews, Recommendations, Client Feedback',
                    'ogType' => 'website',
                    'ogUrl' => route('testimonials'),
                    'ogImage' => asset('images/og-testimonials.jpg'),
                    'canonical' => route('testimonials'),
                    'structuredData' => $this->generateTestimonialsStructuredData()
                ];

            case 'contact':
                return [
                    'title' => 'Contact - ' . $baseTitle,
                    'description' => 'Get in touch with Aziz Khan for project inquiries, collaborations, or job opportunities. Contact form and social media links.',
                    'keywords' => $baseKeywords . ', Contact, Hire, Collaboration, Project Inquiry',
                    'ogType' => 'website',
                    'ogUrl' => route('contact'),
                    'ogImage' => asset('images/og-contact.jpg'),
                    'canonical' => route('contact'),
                    'structuredData' => $this->generateContactStructuredData()
                ];

            default:
                return [
                    'title' => $baseTitle,
                    'description' => $baseDescription,
                    'keywords' => $baseKeywords,
                    'ogType' => 'website',
                    'ogUrl' => url()->current(),
                    'ogImage' => asset('images/og-default.jpg'),
                    'canonical' => url()->current()
                ];
        }
    }

 
    private function generateProjectMetaTags(Project $project): array
    {
        $title = $project->title . ' - Project by Aziz Khan';
        $description = $project->description ?
            substr(strip_tags($project->description), 0, 160) :
            'View detailed information about ' . $project->title . ' project by Aziz Khan.';

        $keywords = 'Project, ' . $project->title;
        if ($project->technologies) {
            $keywords .= ', ' . implode(', ', $project->technologies);
        }
        if ($project->tags) {
            $keywords .= ', ' . implode(', ', $project->tags);
        }

        return [
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords,
            'ogType' => 'article',
            'ogUrl' => route('projects.show', $project->slug),
            'ogImage' => $project->thumbnail ? asset('images/' . $project->thumbnail) : asset('images/og-project-default.jpg'),
            'canonical' => route('projects.show', $project->slug),
            'structuredData' => $this->generateProjectStructuredData($project)
        ];
    }

  
    private function generateBlogMetaTags(Blog $blog): array
    {
        $title = $blog->meta_title ?: ($blog->title . ' - Blog by Aziz Khan');
        $description = $blog->meta_description ?: ($blog->excerpt ?: substr(strip_tags($blog->content), 0, 160));

        $keywords = 'Blog, Article, ' . $blog->title;
        if ($blog->tags) {
            $keywords .= ', ' . implode(', ', $blog->tags);
        }

        return [
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords,
            'ogType' => 'article',
            'ogUrl' => route('blog.show', $blog->slug),
            'ogImage' => $blog->thumbnail ? asset('images/' . $blog->thumbnail) : asset('images/og-blog-default.jpg'),
            'canonical' => route('blog.show', $blog->slug),
            'structuredData' => $this->generateBlogPostStructuredData($blog)
        ];
    }


    private function generatePersonStructuredData(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => 'Aziz Khan',
            'jobTitle' => '2D/3D Artist & Web Developer',
            'description' => 'Professional 2D/3D Artist and Web Developer specializing in Laravel, 3ds Max, UI/UX design, and digital solutions.',
            'url' => url('/'),
            'sameAs' => [
                'https://linkedin.com/in/azizkhan',
                'https://github.com/azizkhan',
                'https://artstation.com/azizkhan'
            ],
            'knowsAbout' => [
                'Web Development',
                '3D Modeling',
                'Laravel',
                '3ds Max',
                'UI/UX Design',
                'Retopology',
                'Rigging',
                'Rendering'
            ],
            'hasOccupation' => [
                [
                    '@type' => 'Occupation',
                    'name' => '2D/3D Artist',
                    'description' => 'Creating digital art, 3D models, and visual content'
                ],
                [
                    '@type' => 'Occupation',
                    'name' => 'Web Developer',
                    'description' => 'Developing web applications using Laravel and modern technologies'
                ]
            ]
        ];
    }

  
    private function generateProjectStructuredData(Project $project): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'CreativeWork',
            'name' => $project->title,
            'description' => strip_tags($project->description),
            'creator' => [
                '@type' => 'Person',
                'name' => 'Aziz Khan'
            ],
            'url' => route('projects.show', $project->slug),
            'image' => $project->thumbnail ? asset('images/' . $project->thumbnail) : null,
            'keywords' => $project->tags ? implode(', ', $project->tags) : null,
            'dateCreated' => $project->created_at->toISOString(),
            'dateModified' => $project->updated_at->toISOString()
        ];
    }

  
    private function generateBlogPostStructuredData(Blog $blog): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $blog->title,
            'description' => $blog->excerpt ?: substr(strip_tags($blog->content), 0, 160),
            'author' => [
                '@type' => 'Person',
                'name' => 'Aziz Khan'
            ],
            'publisher' => [
                '@type' => 'Person',
                'name' => 'Aziz Khan'
            ],
            'url' => route('blog.show', $blog->slug),
            'image' => $blog->thumbnail ? asset('images/' . $blog->thumbnail) : null,
            'keywords' => $blog->tags ? implode(', ', $blog->tags) : null,
            'datePublished' => $blog->published_at ? $blog->published_at->toISOString() : $blog->created_at->toISOString(),
            'dateModified' => $blog->updated_at->toISOString(),
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => route('blog.show', $blog->slug)
            ]
        ];
    }

    
    private function generateProjectsStructuredData(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => 'Projects by Aziz Khan',
            'description' => 'Portfolio of web development and 3D art projects',
            'url' => route('projects.index'),
            'mainEntity' => [
                '@type' => 'ItemList',
                'name' => 'Projects',
                'description' => 'Collection of professional projects'
            ]
        ];
    }

 
    private function generateBlogStructuredData(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Blog',
            'name' => 'Aziz Khan Blog',
            'description' => 'Insights, tutorials, and thoughts on web development and 3D art',
            'url' => route('blog.index'),
            'author' => [
                '@type' => 'Person',
                'name' => 'Aziz Khan'
            ]
        ];
    }

    
    private function generateServicesStructuredData(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'ProfessionalService',
            'name' => 'Aziz Khan Professional Services',
            'description' => 'Web development, 3D modeling, and digital design services',
            'provider' => [
                '@type' => 'Person',
                'name' => 'Aziz Khan'
            ],
            'serviceType' => [
                'Web Development',
                '3D Modeling',
                'UI/UX Design',
                'Retopology',
                'Rigging',
                'Rendering'
            ],
            'areaServed' => 'Worldwide',
            'url' => route('services')
        ];
    }

   
    private function generateTestimonialsStructuredData(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => 'Testimonials - Aziz Khan',
            'description' => 'Client testimonials and professional recommendations',
            'url' => route('testimonials'),
            'mainEntity' => [
                '@type' => 'ItemList',
                'name' => 'Client Testimonials',
                'description' => 'Reviews and recommendations from clients and colleagues'
            ]
        ];
    }

   
    private function generateContactStructuredData(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'ContactPage',
            'name' => 'Contact Aziz Khan',
            'description' => 'Get in touch for project inquiries and collaborations',
            'url' => route('contact'),
            'mainEntity' => [
                '@type' => 'Person',
                'name' => 'Aziz Khan',
                'contactPoint' => [
                    '@type' => 'ContactPoint',
                    'contactType' => 'Professional Inquiry'
                ]
            ]
        ];
    }

  
    public function generateSitemapData(): array
    {
        $urls = [];

        
        $staticPages = [
            ['url' => url('/'), 'priority' => '1.0', 'changefreq' => 'weekly'],
            ['url' => route('about'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => route('projects.index'), 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['url' => route('blog.index'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['url' => route('services'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => route('testimonials'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => route('contact'), 'priority' => '0.6', 'changefreq' => 'monthly'],
        ];

        foreach ($staticPages as $page) {
            $urls[] = array_merge($page, [
                'lastmod' => now()->toISOString()
            ]);
        }

        
        $projects = Project::where('status', 'published')->get();
        foreach ($projects as $project) {
            $urls[] = [
                'url' => route('projects.show', $project->slug),
                'lastmod' => $project->updated_at->toISOString(),
                'priority' => '0.8',
                'changefreq' => 'monthly'
            ];
        }

       
        $blogs = Blog::where('status', 'published')->get();
        foreach ($blogs as $blog) {
            $urls[] = [
                'url' => route('blog.show', $blog->slug),
                'lastmod' => $blog->updated_at->toISOString(),
                'priority' => '0.7',
                'changefreq' => 'weekly'
            ];
        }

        return $urls;
    }

  
    public function generateRobotsTxt(): string
    {
        $content = "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /storage/\n";
        $content .= "Disallow: /vendor/\n";
        $content .= "\n";
        $content .= "Sitemap: " . url('/sitemap.xml') . "\n";

        return $content;
    }
}
