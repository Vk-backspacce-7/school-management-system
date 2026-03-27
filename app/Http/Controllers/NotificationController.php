<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NotificationController extends Controller
{
     
    public function index(Request $request): View
    {
        $notifications = $request->user()
            ->notifications()
            ->latest()
            ->paginate(30);

        return view('notifications.index', compact('notifications'));
    }
 
    public function markAsRead(Request $request, string $id): RedirectResponse
    {
        $notification = $request->user()->notifications()->where('id', $id)->firstOrFail();

        if ($notification->read_at === null) {
            $notification->markAsRead();
        }

        // OLD REDIRECT LOGIC REMOVED (commented for safe migration):
        // $redirectTo = (string) ($request->query('redirect_to') ?? $request->input('redirect_to', ''));
        // $appHost = parse_url((string) config('app.url'), PHP_URL_HOST);
        // $targetHost = parse_url($redirectTo, PHP_URL_HOST);
        // $isRelativePath = Str::startsWith($redirectTo, ['/']);
        // $isSameHostAbsoluteUrl = $redirectTo !== ''
        //     && filter_var($redirectTo, FILTER_VALIDATE_URL) !== false
        //     && $targetHost !== null
        //     && $appHost !== null
        //     && mb_strtolower((string) $targetHost) === mb_strtolower((string) $appHost);
        // if ($redirectTo !== '' && ($isRelativePath || $isSameHostAbsoluteUrl)) {
        //     return redirect($redirectTo)->with('info', 'Notification marked as read.');
        // }

        return back()->with('info', 'Notification marked as read.');
    }

  
    public function markAllAsRead(Request $request): RedirectResponse
    {
         
        $request->user()->unreadNotifications()->update([
            'read_at' => now(),
        ]);

        return back()->with('info', 'All notifications marked as read.');
    }

    /**
     * Delete complete notification history for logged-in user.
     */
    public function clearAll(Request $request): RedirectResponse
    {
        // OLD BEHAVIOR (commented for safe migration):
        // There was no "delete all history" endpoint before.

        $request->user()->notifications()->delete();

        return back()->with('info', 'Notification history deleted successfully.');
    }
}
