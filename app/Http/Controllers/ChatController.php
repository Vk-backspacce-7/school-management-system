<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ChatController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $authUser = $request->user();
        $participants = $this->allowedContacts($authUser);

        $requestedReceiverId = (int) $request->integer('receiver_id');

        $activeContact = $requestedReceiverId > 0
            ? $participants->firstWhere('id', $requestedReceiverId)
            : $participants->first();

        if ($activeContact) {
            Message::query()
                ->where('sender_id', $activeContact->id)
                ->where('receiver_id', $authUser->id)
                ->where('is_seen', false)
                ->update(['is_seen' => true]);
        }

        $messages = collect();

        if ($activeContact) {
            $messages = $this->conversationBetween($authUser->id, $activeContact->id)
                ->orderBy('created_at')
                ->orderBy('id')
                ->get();
        }

        $role = $this->normalizedRole($authUser->role);
        $isPrincipal = $role === 'principal';

        return response()->json([
            'current_user' => [
                'id' => $authUser->id,
                'name' => $authUser->name,
                'role' => $role,
            ],
            'participants' => $participants->map(function (User $user) use ($isPrincipal, $authUser) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $this->normalizedRole($user->role),
                    'unread_count' => $isPrincipal
                        ? Message::query()
                            ->where('sender_id', $user->id)
                            ->where('receiver_id', $authUser->id)
                            ->where('is_seen', false)
                            ->count()
                        : 0,
                ];
            })->values(),
            'active_receiver_id' => $activeContact?->id,
            'messages' => $messages->map(fn (Message $message) => $this->messagePayload($message))->values(),
            'show_popup_notifications' => $isPrincipal,
            'unread_count' => $isPrincipal
                ? Message::query()
                    ->where('receiver_id', $authUser->id)
                    ->where('is_seen', false)
                    ->count()
                : 0,
        ]);
    }

    public function sendMessage(Request $request): JsonResponse
    {
        $authUser = $request->user();

        $validated = $request->validate([
            'receiver_id' => ['required', 'integer', 'exists:users,id'],
            'message' => ['required', 'string', 'max:3000'],
        ]);

        $content = trim($validated['message']);

        if ($content === '') {
            return response()->json([
                'message' => 'Message text is required.',
                'errors' => [
                    'message' => ['Message text is required.'],
                ],
            ], 422);
        }

        $receiver = User::query()->findOrFail((int) $validated['receiver_id']);

        $this->ensureCanChat($authUser, $receiver);

        $message = Message::query()->create([
            'sender_id' => $authUser->id,
            'receiver_id' => $receiver->id,
            'message' => $content,
            'is_seen' => false,
        ]);

        $message->loadMissing(['sender:id,name,role', 'receiver:id,name,role']);

        event(new MessageSent($message));

        $isPrincipal = $this->normalizedRole($authUser->role) === 'principal';

        return response()->json([
            'message' => $this->messagePayload($message),
            'unread_count' => $isPrincipal
                ? Message::query()
                    ->where('receiver_id', $authUser->id)
                    ->where('is_seen', false)
                    ->count()
                : 0,
        ], 201);
    }

    private function allowedContacts(User $authUser): Collection
    {
        $role = $this->normalizedRole($authUser->role);

        if ($role === 'teacher') {
            return User::query()
                ->whereRaw('LOWER(role) = ?', ['principal'])
                ->orderBy('name')
                ->get(['id', 'name', 'role']);
        }

        if ($role === 'principal') {
            return User::query()
                ->whereRaw('LOWER(role) = ?', ['teacher'])
                ->orderBy('name')
                ->get(['id', 'name', 'role']);
        }

        abort(403, 'Only teacher and principal roles can use chat.');
    }

    private function ensureCanChat(User $sender, User $receiver): void
    {
        if ((int) $sender->id === (int) $receiver->id) {
            abort(403, 'You cannot chat with yourself.');
        }

        $senderRole = $this->normalizedRole($sender->role);
        $receiverRole = $this->normalizedRole($receiver->role);

        $teacherToPrincipal = $senderRole === 'teacher' && $receiverRole === 'principal';
        $principalToTeacher = $senderRole === 'principal' && $receiverRole === 'teacher';

        if (! $teacherToPrincipal && ! $principalToTeacher) {
            abort(403, 'This chat pair is not allowed.');
        }
    }

    private function conversationBetween(int $firstUserId, int $secondUserId)
    {
        return Message::query()
            ->where(function ($query) use ($firstUserId, $secondUserId) {
                $query->where('sender_id', $firstUserId)
                    ->where('receiver_id', $secondUserId);
            })
            ->orWhere(function ($query) use ($firstUserId, $secondUserId) {
                $query->where('sender_id', $secondUserId)
                    ->where('receiver_id', $firstUserId);
            });
    }

    private function messagePayload(Message $message): array
    {
        return [
            'id' => $message->id,
            'sender_id' => $message->sender_id,
            'receiver_id' => $message->receiver_id,
            'message' => $message->message,
            'is_seen' => (bool) $message->is_seen,
            'created_at' => $message->created_at?->toISOString(),
            'created_at_readable' => $message->created_at?->format('h:i A'),
            'sender_name' => $message->relationLoaded('sender')
                ? $message->sender?->name
                : null,
        ];
    }

    private function normalizedRole(?string $role): string
    {
        return strtolower(trim((string) $role));
    }
}
