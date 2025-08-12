<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(Page $page)
    {
        if (!$page->is_published) {
            abort(404);
        }

        $template = match($page->template) {
            'full-width' => 'pages.templates.full-width',
            'minimal' => 'pages.templates.minimal',
            default => 'pages.templates.default',
        };

        return view($template, compact('page'));
    }
}
