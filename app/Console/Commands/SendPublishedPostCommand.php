<?php

namespace App\Console\Commands;

use App\Jobs\SendPublishedPostToNotReceivedUsersJob;
use Illuminate\Console\Command;

class SendPublishedPostCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sent:published-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send published post to user has not received yet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Prepare job to send...');
        SendPublishedPostToNotReceivedUsersJob::dispatch();
        $this->info('Job has been started.');
    }
}
