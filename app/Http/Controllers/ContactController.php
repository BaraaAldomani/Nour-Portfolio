<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\ContactMessage;
use App\Support\PageMeta;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * The contact form writes to the database rather than sending mail, so the site
 * needs no SMTP credentials to work. Messages surface in the admin Inbox.
 */
final class ContactController extends Controller
{
    public function show(): View
    {
        return view('pages.contact', ['meta' => PageMeta::for('contact')]);
    }

    public function store(ContactRequest $request): RedirectResponse
    {
        ContactMessage::create([
            'name'    => $request->string('name')->trim()->value(),
            'email'   => $request->string('email')->trim()->lower()->value(),
            'message' => $request->string('message')->trim()->value(),
            'locale'  => app()->getLocale(),
            'ip'      => $request->ip(),
        ]);

        return redirect()
            ->route('contact')
            ->with('contact.success', setting_text('contact.success', __('contact.success')));
    }
}
