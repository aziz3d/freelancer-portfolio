<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Services\SEOService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    protected $seoService;

    public function __construct(SEOService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function index()
    {
        $pageTitleSettings = Content::byKey('page_titles_about')->first();
        $defaultPageTitle = [
            'title' => 'About ' . (config('app.name', 'Aziz Khan')),
            'content' => '2D/3D Artist & Web Developer passionate about creating digital experiences and innovative solutions.',
            'meta' => ['subtitle' => '']
        ];

        $profileSummary = Content::byKey('about_profile_summary')->first();
        $skills = Content::byKey('about_skills')->first();
        $experience = Content::byKey('about_experience')->first();
        
        $defaultProfileSummary = [
            'title' => 'My Story',
            'content' => 'Passionate 2D/3D Artist & Web Developer with expertise in creating digital experiences that blend creativity with technical excellence. I specialize in web development using modern frameworks like Laravel, and 3D modeling with industry-standard tools.',
            'meta' => [
                'image' => '/images/about/profile.jpg',
                'years_experience' => 5,
                'projects_completed' => 50
            ]
        ];
        
        $defaultSkills = [
            'title' => 'Skills & Technologies',
            'content' => 'Technical expertise across multiple domains',
            'meta' => [
                'categories' => [
                    [
                        'name' => 'Web Development',
                        'skills' => [
                            ['name' => 'Laravel', 'level' => 90, 'icon' => 'laravel'],
                            ['name' => 'PHP', 'level' => 85, 'icon' => 'php'],
                            ['name' => 'JavaScript', 'level' => 80, 'icon' => 'javascript'],
                            ['name' => 'Vue.js', 'level' => 75, 'icon' => 'vue'],
                            ['name' => 'Tailwind CSS', 'level' => 90, 'icon' => 'tailwind']
                        ]
                    ],
                    [
                        'name' => '3D Modeling & Animation',
                        'skills' => [
                            ['name' => '3ds Max', 'level' => 95, 'icon' => '3dsmax'],
                            ['name' => 'Blender', 'level' => 80, 'icon' => 'blender'],
                            ['name' => 'Maya', 'level' => 70, 'icon' => 'maya'],
                            ['name' => 'ZBrush', 'level' => 75, 'icon' => 'zbrush'],
                            ['name' => 'Substance Painter', 'level' => 80, 'icon' => 'substance']
                        ]
                    ],
                    [
                        'name' => 'Design & UI/UX',
                        'skills' => [
                            ['name' => 'Figma', 'level' => 85, 'icon' => 'figma'],
                            ['name' => 'Adobe Photoshop', 'level' => 90, 'icon' => 'photoshop'],
                            ['name' => 'Adobe Illustrator', 'level' => 80, 'icon' => 'illustrator'],
                            ['name' => 'UI/UX Design', 'level' => 85, 'icon' => 'design'],
                            ['name' => 'Prototyping', 'level' => 80, 'icon' => 'prototype']
                        ]
                    ]
                ]
            ]
        ];
        
        $defaultExperience = [
            'title' => 'Work Experience',
            'content' => 'Professional journey and key achievements',
            'meta' => [
                'timeline' => [
                    [
                        'position' => 'Senior 3D Artist & Web Developer',
                        'company' => 'Freelance',
                        'location' => 'Remote',
                        'period' => '2022 - Present',
                        'description' => 'Leading 3D modeling projects and developing custom web applications for clients worldwide. Specialized in architectural visualization and e-commerce platforms.',
                        'achievements' => [
                            'Completed 25+ 3D visualization projects',
                            'Developed 10+ Laravel applications',
                            'Maintained 98% client satisfaction rate'
                        ],
                        'technologies' => ['Laravel', '3ds Max', 'Vue.js', 'Tailwind CSS']
                    ],
                    [
                        'position' => '3D Modeler & Web Developer',
                        'company' => 'Digital Studio',
                        'location' => 'Karachi, Pakistan',
                        'period' => '2020 - 2022',
                        'description' => 'Created high-quality 3D models for games and architectural projects while developing web solutions for internal tools and client projects.',
                        'achievements' => [
                            'Reduced modeling time by 30% through workflow optimization',
                            'Built internal project management system',
                            'Mentored junior developers'
                        ],
                        'technologies' => ['3ds Max', 'PHP', 'MySQL', 'JavaScript']
                    ],
                    [
                        'position' => 'Junior 3D Artist',
                        'company' => 'Creative Agency',
                        'location' => 'Karachi, Pakistan',
                        'period' => '2019 - 2020',
                        'description' => 'Started career focusing on 3D modeling and animation for advertising campaigns and product visualizations.',
                        'achievements' => [
                            'Created 3D assets for 15+ advertising campaigns',
                            'Learned advanced texturing and lighting techniques',
                            'Collaborated with design teams on creative projects'
                        ],
                        'technologies' => ['3ds Max', 'V-Ray', 'Photoshop']
                    ]
                ]
            ]
        ];
        
        $seoData = $this->seoService->generateMetaTags('about');

        $socialLinks = Content::byKey('about_social_links')->first();
        $defaultSocialLinks = [
            'title' => 'Connect With Me',
            'content' => 'Follow me on social media for updates and insights',
            'meta' => [
                'social_links' => [
                    ['platform' => 'LinkedIn', 'url' => '#', 'icon' => 'linkedin'],
                    ['platform' => 'GitHub', 'url' => '#', 'icon' => 'github'],
                    ['platform' => 'ArtStation', 'url' => '#', 'icon' => 'artstation'],
                    ['platform' => 'Behance', 'url' => '#', 'icon' => 'behance']
                ]
            ]
        ];

        $cta = Content::byKey('about_cta')->first();
        $defaultCta = [
            'title' => 'Ready to Work Together?',
            'content' => "Let's discuss your next project and bring your ideas to life.",
            'meta' => [
                'primary_button_text' => 'Start a Project',
                'secondary_button_text' => 'View My Work'
            ]
        ];

        return view('pages.about', [
            'pageTitle' => $pageTitleSettings ? $pageTitleSettings->toArray() : $defaultPageTitle,
            'profileSummary' => $profileSummary ? $profileSummary->toArray() : $defaultProfileSummary,
            'skills' => $skills ? $skills->toArray() : $defaultSkills,
            'experience' => $experience ? $experience->toArray() : $defaultExperience,
            'socialLinks' => $socialLinks ? $socialLinks->toArray() : $defaultSocialLinks,
            'cta' => $cta ? $cta->toArray() : $defaultCta,
            'seoData' => $seoData
        ]);
    }
    
    public function downloadResume()
    {
        try {
            
            $resumeSettings = Content::byKey('about_resume')->first();
            
           
            if (!$resumeSettings || !isset($resumeSettings->meta['resume_path'])) {
                $defaultPaths = [
                    'public/documents/aziz-khan-resume.pdf',
                    'public/documents/resume.pdf',
                    'public/resume.pdf'
                ];
                
                foreach ($defaultPaths as $defaultPath) {
                    if (Storage::exists($defaultPath)) {
                        return Storage::download($defaultPath, 'Aziz-Khan-Resume.pdf', [
                            'Content-Type' => 'application/pdf',
                        ]);
                    }
                }
                
                return response()->view('errors.resume-not-found', [], 404);
            }
            
            $resumePath = $resumeSettings->meta['resume_path'];
            
            
            $possiblePaths = [
                'public/' . $resumePath,  
                $resumePath,              
                'public/content/' . basename($resumePath), 
                'public/documents/' . basename($resumePath), 
            ];
            
            $foundPath = null;
            foreach ($possiblePaths as $path) {
                if (Storage::exists($path)) {
                    $foundPath = $path;
                    break;
                }
            }
            
            if (!$foundPath) {
                $fileSystemPaths = [
                    storage_path('app/public/' . $resumePath),
                    storage_path('app/' . $resumePath),
                    public_path('storage/' . $resumePath),
                    public_path('documents/' . basename($resumePath)),
                ];
                
                foreach ($fileSystemPaths as $fsPath) {
                    if (file_exists($fsPath)) {
                        return response()->download($fsPath, 'Aziz-Khan-Resume.pdf', [
                            'Content-Type' => 'application/pdf',
                        ]);
                    }
                }
            }
            
            if (!$foundPath) {
                return response()->view('errors.resume-debug', [
                    'resumePath' => $resumePath,
                    'searchedPaths' => $possiblePaths,
                    'resumeSettings' => $resumeSettings
                ], 404);
            }
            
            $filename = 'Aziz-Khan-Resume.pdf';
            if ($resumeSettings && isset($resumeSettings->meta['button_text'])) {
                $buttonText = $resumeSettings->meta['button_text'];
                $filename = preg_replace('/[^a-zA-Z0-9\-_\.]/', '-', $buttonText) . '.pdf';
            }
            
            return Storage::download($foundPath, $filename, [
                'Content-Type' => 'application/pdf',
            ]);
            
        } catch (\Exception $e) {
            
            \Log::error('Resume download error: ' . $e->getMessage());
            
            return response()->view('errors.resume-error', [
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function debugResume()
    {
        $resumeSettings = Content::byKey('about_resume')->first();
        
        $debug = [
            'resume_settings_exists' => $resumeSettings ? 'Yes' : 'No',
            'meta_data' => $resumeSettings ? $resumeSettings->meta : 'No meta data',
            'resume_path' => $resumeSettings && isset($resumeSettings->meta['resume_path']) ? $resumeSettings->meta['resume_path'] : 'No path set',
            'storage_files_content' => Storage::disk('public')->allFiles('content'),
            'storage_files_documents' => Storage::disk('public')->allFiles('documents'),
            'all_public_files' => Storage::allFiles('public'),
            'storage_path' => storage_path('app/public'),
            'public_path' => public_path('storage'),
            'symlink_exists' => is_link(public_path('storage')),
        ];
        
        return response()->json($debug);
    }

    public function createDefaultResume()
    {
        if (!Storage::disk('public')->exists('documents')) {
            Storage::disk('public')->makeDirectory('documents');
        }
        
        $pdfContent = "%PDF-1.4\n1 0 obj\n<<\n/Type /Catalog\n/Pages 2 0 R\n>>\nendobj\n2 0 obj\n<<\n/Type /Pages\n/Kids [3 0 R]\n/Count 1\n>>\nendobj\n3 0 obj\n<<\n/Type /Page\n/Parent 2 0 R\n/MediaBox [0 0 612 792]\n/Contents 4 0 R\n>>\nendobj\n4 0 obj\n<<\n/Length 44\n>>\nstream\nBT\n/F1 12 Tf\n100 700 Td\n(Aziz Khan Resume) Tj\nET\nendstream\nendobj\nxref\n0 5\n0000000000 65535 f \n0000000009 00000 n \n0000000058 00000 n \n0000000115 00000 n \n0000000206 00000 n \ntrailer\n<<\n/Size 5\n/Root 1 0 R\n>>\nstartxref\n299\n%%EOF";
        
        Storage::disk('public')->put('documents/aziz-khan-resume.pdf', $pdfContent);
        
        Content::updateOrCreate(
            ['key' => 'about_resume'],
            [
                'title' => 'Resume Settings',
                'content' => 'Resume download settings',
                'meta' => [
                    'resume_path' => 'documents/aziz-khan-resume.pdf',
                    'button_text' => 'Download Resume'
                ]
            ]
        );
        
        return response()->json(['message' => 'Default resume created successfully']);
    }
}