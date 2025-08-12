<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{

    public function run(): void
    {
        
        $featuredBlogs = [
            [
                'title' => 'Building Scalable Laravel Applications: Best Practices for 2025',
                'slug' => 'building-scalable-laravel-applications-best-practices-2025',
                'excerpt' => 'Discover the latest techniques and architectural patterns for building Laravel applications that can handle millions of users while maintaining clean, maintainable code.',
                'content' => '# Building Scalable Laravel Applications: Best Practices for 2025

As Laravel continues to evolve, so do the best practices for building scalable applications. In this comprehensive guide, I\'ll share the techniques and architectural patterns I\'ve learned from building applications that serve millions of users.

## Database Optimization Strategies

One of the most critical aspects of scaling Laravel applications is database optimization. Here are the key strategies I implement:

### 1. Query Optimization
- Use eager loading to prevent N+1 queries
- Implement database indexing strategically
- Utilize Laravel\'s query builder for complex queries
- Consider database sharding for extremely large datasets

### 2. Caching Layers
Laravel\'s caching system is incredibly powerful when used correctly:

```php
// Cache expensive queries
$users = Cache::remember(\'active_users\', 3600, function () {
    return User::where(\'active\', true)->get();
});
```

## Architecture Patterns

### Service Layer Pattern
Implementing a service layer helps separate business logic from controllers:

```php
class UserService
{
    public function createUser(array $data): User
    {
        // Business logic here
        return User::create($data);
    }
}
```

### Repository Pattern
While controversial, the repository pattern can be beneficial for complex applications:

```php
interface UserRepositoryInterface
{
    public function findActiveUsers(): Collection;
}
```

## Performance Monitoring

Monitoring is crucial for maintaining scalable applications. I recommend:

- Laravel Telescope for development debugging
- New Relic or Datadog for production monitoring
- Custom metrics for business-specific KPIs

## Conclusion

Building scalable Laravel applications requires careful planning and implementation of proven patterns. By following these practices, you can create applications that grow with your business needs.',
                'thumbnail' => 'portfolio_24.jpg',
                'meta_title' => 'Building Scalable Laravel Applications: Best Practices for 2024 | Aziz Khan Blog',
                'meta_description' => 'Learn the latest techniques for building scalable Laravel applications that can handle millions of users. Database optimization, caching strategies, and architectural patterns.',
                'tags' => ['Laravel', 'PHP', 'Web Development', 'Scalability', 'Best Practices'],
                'status' => 'published',
                'published_at' => now()->subDays(2)
            ],
            [
                'title' => 'The Future of 3D Modeling: AI-Assisted Workflows in 2025',
                'slug' => 'future-3d-modeling-ai-assisted-workflows-2024',
                'excerpt' => 'Explore how artificial intelligence is revolutionizing 3D modeling workflows',
                'content' => '# The Future of 3D Modeling: AI-Assisted Workflows in 2025

The 3D modeling industry is experiencing a revolutionary transformation with the integration of artificial intelligence. As someone who has been working in 3D for over five years.

## Machine-Powered Retopology

One of the most time-consuming aspects of 3D modeling has always been retopology:

### Automated Mesh Optimization
- Tools like Instant Meshes and Quad Remesher
- Automatic UV unwrapping optimization

### Benefits I\'ve Experienced:
- 70% reduction in retopology time
- More consistent mesh quality
- Better animation-ready topology

## Procedural Texture Generation

Ttexture generation has become incredibly sophisticated:

### Substance Designer Integration
- Automatic PBR map generation
- Style transfer for textures

### Real-World Applications:
I recently used Rizomuv for texture generation for a architectural visualization project, reducing texture creation time from days to hours while maintaining photorealistic quality.

## Machine Learning in Animation

## Challenges and Considerations


### Technical Integration
- Learning new AI-powered tools
- Adapting existing workflows
- Hardware requirements for AI processing

## Looking Forward

The future of 3D modeling will likely see:

- More sophisticated AI assistants
- Real-time AI-powered rendering
- Automated scene composition
- AI-driven lighting optimization

## Conclusion

AI is not replacing 3D artists but empowering us to focus on creativity while automating repetitive tasks. The key is learning to work alongside these tools effectively.',
                'thumbnail' => 'portfolio_25.jpg',
                'meta_title' => 'The Future of 3D Modeling: AI-Assisted Workflows in 2025 | Aziz Khan Blog',
                'meta_description' => 'Discover how AI is revolutionizing 3D modeling workflows. Learn about automated retopology, AI texture generation, and machine learning in animation.',
                'tags' => ['3D Modeling', 'AI', 'Workflow', 'Technology', 'Future Trends'],
                'status' => 'published',
                'published_at' => now()->subDays(5)
            ],
            [
                'title' => 'Vue.js 3 Composition API: A Complete Guide for Laravel Developers',
                'slug' => 'vuejs-3-composition-api-complete-guide-laravel-developers',
                'excerpt' => 'Master Vue.js 3 Composition API and learn how to integrate it seamlessly with Laravel backends for modern, reactive web applications.',
                'content' => '# Vue.js 3 Composition API: A Complete Guide for Laravel Developers

Vue.js 3 introduced the Composition API, a powerful new way to organize and reuse component logic. As a Laravel developer, understanding how to leverage this API can significantly improve your frontend development experience.

## Why Composition API?

The Composition API addresses several limitations of the Options API:

### Better Logic Reuse
```javascript
// Composable function
import { ref, computed } from \'vue\'

export function useCounter() {
  const count = ref(0)
  const doubleCount = computed(() => count.value * 2)
  
  function increment() {
    count.value++
  }
  
  return { count, doubleCount, increment }
}
```

### Improved TypeScript Support
The Composition API provides better type inference and IDE support.

### Better Organization
Related logic can be grouped together instead of being scattered across different options.

## Laravel Integration Patterns

### API Communication
Here\'s how I structure API calls in Vue components:

```javascript
import { ref, onMounted } from \'vue\'
import axios from \'axios\'

export default {
  setup() {
    const users = ref([])
    const loading = ref(false)
    const error = ref(null)
    
    const fetchUsers = async () => {
      loading.value = true
      try {
        const response = await axios.get(\'/api/users\')
        users.value = response.data.data
      } catch (err) {
        error.value = err.message
      } finally {
        loading.value = false
      }
    }
    
    onMounted(fetchUsers)
    
    return { users, loading, error, fetchUsers }
  }
}
```

### Form Handling
Integrating with Laravel validation:

```javascript
import { reactive, ref } from \'vue\'

export function useForm(initialData) {
  const form = reactive({ ...initialData })
  const errors = ref({})
  const processing = ref(false)
  
  const submit = async (url) => {
    processing.value = true
    errors.value = {}
    
    try {
      const response = await axios.post(url, form)
      return response.data
    } catch (error) {
      if (error.response?.status === 422) {
        errors.value = error.response.data.errors
      }
      throw error
    } finally {
      processing.value = false
    }
  }
  
  return { form, errors, processing, submit }
}
```

## Advanced Patterns

### Custom Composables
Creating reusable logic for common Laravel patterns:

```javascript
// useAuth.js
import { ref, computed } from \'vue\'

const user = ref(null)
const token = ref(localStorage.getItem(\'token\'))

export function useAuth() {
  const isAuthenticated = computed(() => !!token.value)
  
  const login = async (credentials) => {
    const response = await axios.post(\'/api/login\', credentials)
    token.value = response.data.token
    user.value = response.data.user
    localStorage.setItem(\'token\', token.value)
  }
  
  const logout = () => {
    token.value = null
    user.value = null
    localStorage.removeItem(\'token\')
  }
  
  return { user, isAuthenticated, login, logout }
}
```

### Real-time Updates
Integrating with Laravel Echo:

```javascript
import { ref, onMounted, onUnmounted } from \'vue\'

export function useRealtime(channel) {
  const data = ref([])
  let echoChannel = null
  
  onMounted(() => {
    echoChannel = window.Echo.channel(channel)
      .listen(\'DataUpdated\', (e) => {
        data.value.push(e.data)
      })
  })
  
  onUnmounted(() => {
    if (echoChannel) {
      window.Echo.leaveChannel(channel)
    }
  })
  
  return { data }
}
```

## Best Practices

### 1. Organize Composables
- Create a `composables` directory
- Use descriptive naming conventions
- Keep composables focused and single-purpose

### 2. Error Handling
- Implement consistent error handling patterns
- Use global error handlers for common scenarios
- Provide user-friendly error messages

### 3. Performance Optimization
- Use `shallowRef` for large objects
- Implement proper cleanup in `onUnmounted`
- Lazy load composables when possible

## Conclusion

The Composition API, when combined with Laravel\'s robust backend capabilities, creates a powerful development stack. By following these patterns and best practices, you can build maintainable and scalable applications.',
                'thumbnail' => 'portfolio_27.jpg',
                'meta_title' => 'Vue.js 3 Composition API: Complete Guide for Laravel Developers | Aziz Khan Blog',
                'meta_description' => 'Master Vue.js 3 Composition API with Laravel. Learn composables, form handling, real-time updates, and best practices for modern web development.',
                'tags' => ['Vue.js', 'Laravel', 'JavaScript', 'Frontend', 'Tutorial'],
                'status' => 'published',
                'published_at' => now()->subDays(8)
            ],
            [
                'title' => 'Optimizing 3D Renders: Performance vs Quality Balance',
                'slug' => 'optimizing-3d-renders-performance-quality-balance',
                'excerpt' => 'Learn professional techniques for optimizing 3D renders to achieve the perfect balance between rendering speed and visual quality in production environments.',
                'content' => '# Optimizing 3D Renders: Performance vs Quality Balance

In the world of 3D rendering, finding the sweet spot between performance and quality is crucial for meeting deadlines while maintaining professional standards. Here\'s what I\'ve learned from years of commercial rendering work.

## Understanding Render Engines

### V-Ray Optimization
V-Ray remains my go-to renderer for architectural visualization:

#### Sampling Strategies
- Use adaptive sampling for complex scenes
- Optimize noise threshold settings
- Balance between speed and quality

#### Light Cache Settings
```
Light Cache Subdivisions: 1000-1500
Sample Size: 0.02-0.05
Filter Type: Nearest
```

### Arnold Renderer
For character and product rendering:

#### Sampling Optimization
- Camera (AA) samples: 3-6
- Diffuse samples: 2-3
- Specular samples: 2
- Transmission samples: 2

## Scene Optimization Techniques

### Geometry Optimization
1. **Polygon Count Management**
   - Use proxy objects for distant geometry
   - Implement LOD (Level of Detail) systems
   - Remove unnecessary edge loops

2. **Instancing**
   - Use instances for repeated objects
   - Implement scatter systems for vegetation
   - Optimize memory usage with smart instancing

### Texture Optimization
1. **Resolution Management**
   - Use appropriate texture sizes
   - Implement texture streaming
   - Optimize UV layouts

2. **Format Selection**
   - EXR for HDR environments
   - PNG for transparency
   - JPEG for diffuse maps

## Lighting Strategies

### Global Illumination
Balancing GI quality with render times:

#### Primary GI Engine
- Irradiance Map for static scenes
- Light Cache for animations
- Brute Force for final quality

#### Secondary GI Engine
- Light Cache for most scenarios
- Brute Force for critical quality areas

### HDRI Optimization
```
HDRI Resolution: 4K-8K for backgrounds
Environment Resolution: 1K-2K for lighting
Invisible to Camera: Enable for faster renders
```

## Render Passes Strategy

### Essential Passes
1. **Beauty Pass** - Final composite
2. **Diffuse Pass** - Color information
3. **Reflection Pass** - Reflective elements
4. **Shadow Pass** - Shadow information
5. **Z-Depth Pass** - Depth information

### Optimization Benefits
- Faster iterations in post-production
- Selective quality adjustments
- Reduced re-render requirements

## Hardware Considerations

### CPU vs GPU Rendering
#### CPU Advantages:
- Better memory handling
- More stable for complex scenes
- Superior for architectural visualization

#### GPU Advantages:
- Faster preview renders
- Real-time feedback
- Better for iterative design

### Memory Management
```
RAM Requirements:
- Minimum: 32GB
- Recommended: 64GB+
- Professional: 128GB+

VRAM for GPU Rendering:
- Minimum: 8GB
- Recommended: 16GB+
- Professional: 24GB+
```

## Production Workflow

### Render Farm Integration
1. **Scene Preparation**
   - Collect all assets
   - Verify file paths
   - Test render on single frame

2. **Quality Control**
   - Render test strips
   - Verify lighting consistency
   - Check for artifacts

### Time Management
#### Typical Render Times (per frame):
- Preview Quality: 5-15 minutes
- Production Quality: 30-60 minutes
- Final Quality: 1-3 hours

## Post-Production Integration

### Render Elements Usage
- Composite in After Effects or Nuke
- Adjust individual passes
- Add atmospheric effects
- Color correction and grading

### File Management
```
Naming Convention:
ProjectName_SceneName_PassName_Frame####.exr

Example:
ArchViz_Kitchen_Beauty_0001.exr
ArchViz_Kitchen_Reflection_0001.exr
```

## Quality Assurance

### Checklist for Final Renders
- [ ] No visible noise in shadows
- [ ] Proper exposure levels
- [ ] Consistent lighting
- [ ] No geometry artifacts
- [ ] Proper material assignments
- [ ] Correct camera settings

## Conclusion

Optimizing 3D renders is an art that combines technical knowledge with practical experience. The key is understanding your project requirements and choosing the right balance of settings for each specific situation.

Remember: Perfect renders that take forever are often less valuable than good renders delivered on time.',
                'thumbnail' => 'portfolio_28.jpg',
                'meta_title' => 'Optimizing 3D Renders: Performance vs Quality Balance | Aziz Khan Blog',
                'meta_description' => 'Professional techniques for optimizing 3D renders. Learn to balance rendering speed and visual quality with V-Ray, Arnold, and production workflows.',
                'tags' => ['3D Rendering', 'V-Ray', 'Optimization', 'Performance', 'Tutorial'],
                'status' => 'published',
                'published_at' => now()->subDays(12)
            ],
            [
                'title' => 'Modern PHP Development: Laravel 11 New Features Deep Dive',
                'slug' => 'modern-php-development-laravel-11-new-features-deep-dive',
                'excerpt' => 'Explore the latest features in Laravel 11 and how they improve developer productivity, application performance, and code maintainability.',
                'content' => '# Modern PHP Development: Laravel 11 New Features Deep Dive

Laravel 11 brings exciting new features and improvements that enhance developer productivity and application performance. Let\'s explore the most significant additions and how to leverage them effectively.

## Streamlined Application Structure

### Simplified Directory Structure
Laravel 11 introduces a cleaner, more focused directory structure:

```
app/
├── Http/
│   ├── Controllers/
│   └── Middleware/
├── Models/
├── Providers/
└── Services/
```

### Benefits:
- Reduced cognitive overhead
- Faster project navigation
- Cleaner separation of concerns

## Enhanced Routing Capabilities

### Route Model Binding Improvements
```php
// Automatic soft delete handling
Route::get(\'/posts/{post}\', function (Post $post) {
    // Automatically excludes soft-deleted records
    return $post;
});

// Custom key binding
Route::get(\'/users/{user:username}\', function (User $user) {
    return $user;
});
```

### Route Caching Enhancements
- Faster route compilation
- Improved cache invalidation
- Better performance for large applications

## Database and Eloquent Improvements

### New Query Builder Methods
```php
// Simplified conditional queries
$users = User::query()
    ->when($request->has(\'active\'), fn($q) => $q->where(\'active\', true))
    ->when($request->filled(\'search\'), fn($q) => $q->where(\'name\', \'like\', "%{$request->search}%"))
    ->get();

// Improved aggregation methods
$stats = Order::query()
    ->selectRaw(\'
        COUNT(*) as total_orders,
        SUM(amount) as total_revenue,
        AVG(amount) as average_order_value
    \')
    ->first();
```

### Enhanced Model Factories
```php
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            \'name\' => fake()->name(),
            \'email\' => fake()->unique()->safeEmail(),
            \'email_verified_at\' => now(),
            \'password\' => Hash::make(\'password\'),
        ];
    }
    
    // New state methods
    public function verified(): static
    {
        return $this->state([
            \'email_verified_at\' => now(),
        ]);
    }
    
    public function unverified(): static
    {
        return $this->state([
            \'email_verified_at\' => null,
        ]);
    }
}
```

## Improved Testing Experience

### Enhanced HTTP Testing
```php
public function test_user_can_create_post(): void
{
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)
        ->postJson(\'/api/posts\', [
            \'title\' => \'Test Post\',
            \'content\' => \'This is a test post.\',
        ]);
    
    $response->assertStatus(201)
        ->assertJsonStructure([
            \'data\' => [
                \'id\',
                \'title\',
                \'content\',
                \'created_at\',
            ]
        ]);
}
```

### Database Testing Improvements
```php
// Faster database resets
use Illuminate\\Foundation\\Testing\\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_posts_can_be_filtered(): void
    {
        Post::factory()->count(10)->create();
        Post::factory()->count(5)->create([\'status\' => \'published\']);
        
        $response = $this->getJson(\'/api/posts?status=published\');
        
        $response->assertJsonCount(5, \'data\');
    }
}
```

## Performance Enhancements

### Improved Caching
```php
// New cache tags functionality
Cache::tags([\'users\', \'posts\'])->put(\'user.1.posts\', $posts, 3600);

// Invalidate related caches
Cache::tags([\'users\'])->flush();
```

### Queue Improvements
```php
// Better job batching
use Illuminate\\Bus\\Batch;
use Illuminate\\Support\\Facades\\Bus;

$batch = Bus::batch([
    new ProcessPayment($order1),
    new ProcessPayment($order2),
    new ProcessPayment($order3),
])->then(function (Batch $batch) {
    // All jobs completed successfully
})->catch(function (Batch $batch, Throwable $e) {
    // First batch job failure detected
})->finally(function (Batch $batch) {
    // The batch has finished executing
})->dispatch();
```

## Security Enhancements

### Improved Authentication
```php
// Enhanced password validation
use Illuminate\\Validation\\Rules\\Password;

$request->validate([
    \'password\' => [\'required\', Password::min(8)
        ->letters()
        ->mixedCase()
        ->numbers()
        ->symbols()
        ->uncompromised()
    ],
]);
```

### CSRF Protection Improvements
- Better SPA support
- Improved token handling
- Enhanced security headers

## Developer Experience

### Enhanced Artisan Commands
```bash
# New make commands
php artisan make:enum UserStatus
php artisan make:cast MoneyCast
php artisan make:scope ActiveScope

# Improved existing commands
php artisan make:controller PostController --resource --requests
```

### Better Error Handling
```php
// Custom exception handling
class Handler extends ExceptionHandler
{
    public function register(): void
    {
        $this->reportable(function (InvalidOrderException $e) {
            // Custom reporting logic
        });
        
        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->is(\'api/*\')) {
                return response()->json([
                    \'message\' => \'Resource not found.\'
                ], 404);
            }
        });
    }
}
```

## Migration Path

### Upgrading from Laravel 10
1. **Update Dependencies**
   ```bash
   composer require laravel/framework:^11.0
   ```

2. **Update Configuration**
   - Review config file changes
   - Update service providers
   - Check middleware updates

3. **Test Thoroughly**
   - Run existing test suite
   - Check for breaking changes
   - Verify third-party packages

## Best Practices for Laravel 11

### 1. Leverage New Features Gradually
- Start with non-critical features
- Test thoroughly in development
- Monitor performance impact

### 2. Maintain Backward Compatibility
- Keep existing APIs stable
- Use feature flags for new functionality
- Document breaking changes

### 3. Optimize for Performance
- Utilize new caching features
- Implement proper queue strategies
- Monitor application metrics

## Conclusion

Laravel 11 represents a significant step forward in PHP web development. The new features focus on developer productivity, application performance, and code maintainability. By adopting these features thoughtfully, you can build more robust and efficient applications.

The key is to understand each feature\'s benefits and implement them where they provide the most value to your specific use case.',
                'thumbnail' => 'portfolio_29.jpg',
                'meta_title' => 'Modern PHP Development: Laravel 11 New Features Deep Dive | Aziz Khan Blog',
                'meta_description' => 'Explore Laravel 11 new features including streamlined structure, enhanced routing, database improvements, and performance enhancements.',
                'tags' => ['Laravel', 'PHP', 'Web Development', 'Framework', 'New Features'],
                'status' => 'published',
                'published_at' => now()->subDays(15)
            ]
        ];

        foreach ($featuredBlogs as $blog) {
            Blog::create($blog);
        }

        Blog::factory()
            ->count(12)
            ->published()
            ->create();

        Blog::factory()
            ->count(3)
            ->create(['status' => 'draft']);
    }
}
