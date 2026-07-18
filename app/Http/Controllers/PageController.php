<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\PageMeta;
use Illuminate\Contracts\View\View;

/**
 * The public pages. Every one of them reads through the shared $site instance,
 * so the controller's only job is to pick a view and its meta.
 */
final class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home', ['meta' => PageMeta::for('home')]);
    }

    public function about(): View
    {
        return view('pages.about', ['meta' => PageMeta::for('about')]);
    }

    public function portfolio(): View
    {
        return view('pages.portfolio', ['meta' => PageMeta::for('portfolio')]);
    }

    public function experience(): View
    {
        return view('pages.experience', ['meta' => PageMeta::for('experience')]);
    }

    public function services(): View
    {
        return view('pages.services', ['meta' => PageMeta::for('services')]);
    }
}
