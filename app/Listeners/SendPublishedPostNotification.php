<?php

namespace App\Listeners;

use App\Events\PostPublished;
use App\Mail\PublishedPostMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendPublishedPostNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostPublished $event): void
    {
        $usersNoSentYet = User::query()
            ->whereDoesntHave('senedPosts', function ($query) use ($event) {
                $query->where('post_id', $event->post->id);
            })
            ->whereHas('subscribes', function ($query) use ($event) {
                $query->where('site_id', $event->post->site_id);
            })
            ->select(['id', 'email'])
            ->get();

        foreach ($usersNoSentYet as $user) {
            try {
                Mail::to($user)->send(new PublishedPostMail($event->post));
                $user->senedPosts()->create([
                    'post_id' => $event->post->id
                ]);
            } catch (\Exception $ex) {}
        }
    }

    public function failed(PostPublished $event, Throwable $exception)
    {
    }
}
