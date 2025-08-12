<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Http\Requests\Admin\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('sort_order')->paginate(10);
        
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $availableIcons = $this->getAvailableIcons();
        
        return view('admin.services.create', compact('availableIcons'));
    }

    public function store(ServiceRequest $request)
    {
        $validated = $request->validated();

        Service::create($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function show(Service $service)
    {
        return view('admin.services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        $availableIcons = $this->getAvailableIcons();
        
        return view('admin.services.edit', compact('service', 'availableIcons'));
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $validated = $request->validated();

        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate',
            'services' => 'required|array',
            'services.*' => 'exists:services,id',
        ]);

        $services = Service::whereIn('id', $request->services);

        switch ($request->action) {
            case 'delete':
                $services->delete();
                $message = 'Selected services deleted successfully.';
                break;
            case 'activate':
                $services->update(['is_active' => true]);
                $message = 'Selected services activated successfully.';
                break;
            case 'deactivate':
                $services->update(['is_active' => false]);
                $message = 'Selected services deactivated successfully.';
                break;
        }

        return redirect()->route('admin.services.index')
            ->with('success', $message);
    }

    private function getAvailableIcons()
    {
        return [
            'code' => 'Code',
            'cube' => '3D Cube',
            'paint-brush' => 'Paint Brush',
            'cog' => 'Settings/Gear',
            'desktop-computer' => 'Desktop Computer',
            'device-mobile' => 'Mobile Device',
            'photograph' => 'Camera/Photo',
            'film' => 'Film/Video',
            'lightning-bolt' => 'Lightning Bolt',
            'sparkles' => 'Sparkles',
            'eye' => 'Eye',
            'heart' => 'Heart',
            'star' => 'Star',
            'fire' => 'Fire',
            'light-bulb' => 'Light Bulb',
            'puzzle' => 'Puzzle Piece',
            'shield-check' => 'Shield Check',
            'rocket' => 'Rocket',
        ];
    }
}