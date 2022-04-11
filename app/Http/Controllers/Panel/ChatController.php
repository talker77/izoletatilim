<?php

namespace App\Http\Controllers\Panel;

use App\Events\MessageCreated;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Service;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $user = loggedPanelUser();
        $list = $this->getListMessages($user);
        $service = null;
        if ($request->get('service')) {
            $service = Service::find($request->service);
        }
        $fromId = $request->get('from') ?? $service->user_id ?? $list[0]->from_id ?? null;
        $activeMessages = $this->getLastMessages($fromId, $user);
        if (!count($activeMessages) and $service) {
            $activeMessages[] = $this->getFakeWelcomeMessage($service, $user);
        }
        if (!$service) {
            $service = $this->getServiceInfoBetweenTwoUser($fromId, $user);
        }

        $this->markAsReadAllMessages($fromId, (bool)count($activeMessages));

        return view('site.kullanici.chat.index', [
            'list' => $list,
            'activeMessages' => $activeMessages,
            'service' => $service
        ]);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|max:255',
            'to_id' => 'required|numeric',
            'related_id' => 'nullable|numeric',
        ]);
        $message = Message::create(array_merge($validated, [
            'from_id' => $request->user('panel')->id
        ]));
        MessageCreated::dispatch($message);

        success('Mesaj gönderildi');

        return back();
    }


    private function getListMessages(User $user)
    {
        return DB::select("SELECT p1.*
        FROM messages p1
         INNER JOIN
         (
             SELECT max(created_at) MaxPostDate, from_id,to_id
             FROM messages
             WHERE to_id = ?
             GROUP BY from_id
         ) p2
         ON p1.from_id = p2.from_id
             AND p1.created_at = p2.MaxPostDate
         WHERE p1.to_id = ?
         GROUP BY p1.from_id order by p1.created_at desc", [$user->id, $user->id]);
    }

    /**
     * @param $fromUserId
     */
    private function markAsReadAllMessages($fromUserId, $hasActiveMessages)
    {
        if (!$fromUserId or !$hasActiveMessages) return false;
        Message::where(['to_id' => loggedPanelUser()->id, 'from_id' => $fromUserId])
            ->update([
                'read_at' => Carbon::now()
            ]);
    }

    /**
     * iki kullanıcı arasındaki mesajları getir.
     * @param $fromUserId
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function getLastMessages($fromUserId, User $user)
    {
        return Message::with(['from'])
            ->where(function ($query) use ($fromUserId, $user) {
                $query->where('from_id', $fromUserId)
                    ->where('to_id', $user->id);
            })->orWhere(function ($query) use ($fromUserId, $user) {
                $query->where('to_id', $fromUserId)
                    ->where('from_id', $user->id);
            })
            ->orderBy('created_at')->get();
    }

    /**
     * iki kullanıcı arasındaki hizmeti döndür
     * @param $fromUserId
     * @param User $user
     * @return Service|null
     */
    private function getServiceInfoBetweenTwoUser($fromUserId, User $user)
    {
        $message = Message::with(['related'])
            ->where(function ($query) use ($fromUserId, $user) {
                $query->where('from_id', $fromUserId)
                    ->whereNotNull('related_id')
                    ->where('to_id', $user->id);
            })->orWhere(function ($query) use ($fromUserId, $user) {
                $query->where('from_id', $user->id)
                    ->whereNotNull('related_id')
                    ->where('to_id', $fromUserId);
            })
            ->latest()->first();
        return $message ? $message->related : null;
    }

    /**
     * ilk mesaj gönderilmiş mi ?gönderilmemiş ise ekle
     * @param Service $service
     * @param User $user
     */
    private function getFakeWelcomeMessage(Service $service, User $user)
    {
        return new Message([
            'message' => "Merhaba '{$service->title}' hakkında size nasıl yardımcı olabilirim ? ",
            'to_id' => $user->id,
            'from_id' => $service->user_id,
            'related_id' => $service->id
        ]);
    }
}
