<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Page;
use App\Http\Requests\Admin\MenuRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    
    public function index()
    {
        $menus = Menu::with('page')->ordered()->paginate(10);
        
        return view('admin.menus.index', compact('menus'));
    }

    
    public function create()
    {
        $availableIcons = $this->getAvailableIcons();
        $availableRoutes = $this->getAvailableRoutes();
        
        return view('admin.menus.create', compact('availableIcons', 'availableRoutes'));
    }

    
    public function store(MenuRequest $request)
    {
        $validated = $request->validated();
        
        
        $destinationType = $request->input('destination_type', 'route');
        $menuData = [
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'icon' => $validated['icon'],
            'sort_order' => $validated['sort_order'],
            'is_active' => $request->input('is_active') == '1',
            'opens_in_new_tab' => $request->input('opens_in_new_tab') == '1',
            'description' => $validated['description'],
            'route_name' => null,
            'url' => null,
        ];

        
        switch ($destinationType) {
            case 'route':
                $menuData['route_name'] = $validated['route_name'];
                break;
            case 'url':
                $menuData['url'] = $validated['url'];
                break;
            case 'page':
                
                break;
        }

        
        $menu = Menu::create($menuData);

        
        if ($destinationType === 'page' && !empty($validated['page_content'])) {
            Page::create([
                'menu_id' => $menu->id,
                'title' => $validated['title'],
                'slug' => $validated['slug'],
                'content' => $validated['page_content'],
                'excerpt' => $validated['page_excerpt'],
                'meta_title' => $validated['meta_title'] ?? $validated['title'],
                'meta_description' => $validated['meta_description'],
                'meta_keywords' => $validated['meta_keywords'] ?? [],
                'is_published' => true,
                'template' => 'default',
            ]);
        }

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu created successfully.');
    }

    
    public function show(Menu $menu)
    {
        $menu->load('page');
        
        return view('admin.menus.show', compact('menu'));
    }

    
    public function edit(Menu $menu)
    {
        $menu->load('page');
        $availableIcons = $this->getAvailableIcons();
        $availableRoutes = $this->getAvailableRoutes();
        
        return view('admin.menus.edit', compact('menu', 'availableIcons', 'availableRoutes'));
    }

    
    public function update(MenuRequest $request, Menu $menu)
    {
        $validated = $request->validated();
        
        
        \Log::info('Menu update request data:', [
            'menu_id' => $menu->id,
            'is_active_in_request' => $request->has('is_active'),
            'is_active_value' => $request->input('is_active'),
            'opens_in_new_tab_in_request' => $request->has('opens_in_new_tab'),
            'opens_in_new_tab_value' => $request->input('opens_in_new_tab'),
            'all_request_data' => $request->all()
        ]);
        
        
        $destinationType = $request->input('destination_type', 'route');
        $menuData = [
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'icon' => $validated['icon'],
            'sort_order' => $validated['sort_order'],
            'is_active' => $request->input('is_active') == '1',
            'opens_in_new_tab' => $request->input('opens_in_new_tab') == '1',
            'description' => $validated['description'],
            'route_name' => null,
            'url' => null,
        ];
        
        \Log::info('Menu data to update:', $menuData);

        
        switch ($destinationType) {
            case 'route':
                $menuData['route_name'] = $validated['route_name'];
                break;
            case 'url':
                $menuData['url'] = $validated['url'];
                break;
            case 'page':
                
                break;
        }

        
        $menu->update($menuData);
        
        
        $menu->refresh();
        \Log::info('Menu after update:', [
            'id' => $menu->id,
            'title' => $menu->title,
            'is_active' => $menu->is_active,
            'opens_in_new_tab' => $menu->opens_in_new_tab
        ]);
        
        
        if (function_exists('opcache_reset')) {
            opcache_reset();
        }

        
        if ($destinationType === 'page' && !empty($validated['page_content'])) {
            if ($menu->page) {
                
                $menu->page->update([
                    'title' => $validated['title'],
                    'slug' => $validated['slug'],
                    'content' => $validated['page_content'],
                    'excerpt' => $validated['page_excerpt'],
                    'meta_title' => $validated['meta_title'] ?? $validated['title'],
                    'meta_description' => $validated['meta_description'],
                    'meta_keywords' => $validated['meta_keywords'] ?? [],
                ]);
            } else {
                
                Page::create([
                    'menu_id' => $menu->id,
                    'title' => $validated['title'],
                    'slug' => $validated['slug'],
                    'content' => $validated['page_content'],
                    'excerpt' => $validated['page_excerpt'],
                    'meta_title' => $validated['meta_title'] ?? $validated['title'],
                    'meta_description' => $validated['meta_description'],
                    'meta_keywords' => $validated['meta_keywords'] ?? [],
                    'is_published' => true,
                    'template' => 'default',
                ]);
            }
        } else {
            
            if ($menu->page) {
                $menu->page->delete();
            }
        }

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu updated successfully.');
    }

    
    public function destroy(Menu $menu)
    {
        try {
            $menuTitle = $menu->title;
            $menu->delete();

            return redirect()->route('admin.menus.index')
                ->with('success', "Menu '{$menuTitle}' deleted successfully.");
                
        } catch (\Exception $e) {
            return redirect()->route('admin.menus.index')
                ->with('error', 'An error occurred while deleting the menu: ' . $e->getMessage());
        }
    }

    
    public function bulkAction(Request $request)
    {
        
        \Log::info('=== BULK ACTION METHOD CALLED ===');
        \Log::info('Request method: ' . $request->method());
        \Log::info('Request URL: ' . $request->url());
        
        try {
            
            \Log::info('Bulk action request:', [
                'action' => $request->input('action'),
                'menus' => $request->input('menus'),
                'all_data' => $request->all()
            ]);

            $validated = $request->validate([
                'action' => 'required|in:delete,activate,deactivate',
                'menus' => 'required|array',
                'menus.*' => 'exists:menus,id',
            ]);

            \Log::info('Validation passed for action:', $request->input('action'));
            \Log::info('Validated data:', $validated);

            switch ($request->action) {
                case 'delete':
                    $menuIds = $request->input('menus', []);
                    \Log::info('Deleting menus with IDs:', $menuIds);
                    
                    $menusToDelete = Menu::whereIn('id', $menuIds)->get();
                    \Log::info('Found menus to delete:', $menusToDelete->pluck('id', 'title')->toArray());
                    
                    foreach ($menusToDelete as $menu) {
                        $menu->delete();
                    }
                    $count = $menusToDelete->count();
                    \Log::info('Deleted count:', $count);
                    
                    $message = "Successfully deleted {$count} menu(s).";
                    break;
                case 'activate':
                    $menuIds = $request->input('menus', []);
                    \Log::info('Activating menus with IDs:', $menuIds);
                    
                    $menusToUpdate = Menu::whereIn('id', $menuIds)->get();
                    \Log::info('Found menus to activate:', $menusToUpdate->pluck('id', 'title')->toArray());
                    
                    $updated = 0;
                    foreach ($menusToUpdate as $menu) {
                        $menu->is_active = true;
                        if ($menu->save()) {
                            $updated++;
                            \Log::info("Successfully activated menu: {$menu->title} (ID: {$menu->id})");
                        } else {
                            \Log::error("Failed to activate menu: {$menu->title} (ID: {$menu->id})");
                        }
                    }
                    
                    \Log::info('Total updated count:', $updated);
                    $message = "Successfully activated {$updated} menu(s).";
                    break;
                case 'deactivate':
                    $menuIds = $request->input('menus', []);
                    \Log::info('Deactivating menus with IDs:', $menuIds);
                    
                    $menusToUpdate = Menu::whereIn('id', $menuIds)->get();
                    \Log::info('Found menus to deactivate:', $menusToUpdate->pluck('id', 'title')->toArray());
                    
                    $updated = 0;
                    foreach ($menusToUpdate as $menu) {
                        $menu->is_active = false;
                        if ($menu->save()) {
                            $updated++;
                            \Log::info("Successfully deactivated menu: {$menu->title} (ID: {$menu->id})");
                        } else {
                            \Log::error("Failed to deactivate menu: {$menu->title} (ID: {$menu->id})");
                        }
                    }
                    
                    \Log::info('Total updated count:', $updated);
                    $message = "Successfully deactivated {$updated} menu(s).";
                    break;
                default:
                    return redirect()->route('admin.menus.index')
                        ->with('error', 'Invalid action selected.');
            }

            \Log::info('Bulk action completed successfully:', ['message' => $message]);
            
            return redirect()->route('admin.menus.index')
                ->with('success', $message);
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error in bulk action:', ['errors' => $e->errors()]);
            return redirect()->route('admin.menus.index')
                ->withErrors($e->errors())
                ->with('error', 'Validation failed: ' . implode(', ', $e->errors()['action'] ?? $e->errors()['menus'] ?? ['Unknown validation error']));
        } catch (\Exception $e) {
            \Log::error('Bulk action error:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->route('admin.menus.index')
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }



    private function getAvailableIcons()
    {
        return [
            'home' => 'Home',
            'user' => 'User/About',
            'briefcase' => 'Projects/Portfolio',
            'document-text' => 'Blog/Articles',
            'cog' => 'Services',
            'chat-bubble-left-right' => 'Testimonials',
            'envelope' => 'Contact',
            'information-circle' => 'Information',
            'star' => 'Featured',
            'heart' => 'Favorites',
            'eye' => 'Gallery',
            'camera' => 'Photography',
            'code-bracket' => 'Development',
            'paint-brush' => 'Design',
            'academic-cap' => 'Education',
            'trophy' => 'Awards',
            'globe-alt' => 'Global/Web',
            'rocket-launch' => 'Launch/New',
        ];
    }

    
    private function getAvailableRoutes()
    {
        return [
            '' => 'Select a route (optional)',
            'home' => 'Home Page',
            'about' => 'About Page',
            'projects.index' => 'Projects List',
            'blog.index' => 'Blog List',
            'services' => 'Services Page',
            'testimonials' => 'Testimonials Page',
            'contact' => 'Contact Page',
        ];
    }
}
