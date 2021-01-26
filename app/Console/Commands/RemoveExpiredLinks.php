<?php

namespace App\Console\Commands;

use App\Models\Url;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class RemoveExpiredLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:expired_links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify and Remove Expired Links';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            /**
             * Get expired links and delete
             */
            $expiredUrls = Url::where('expiration_date', '<=', Carbon::now())->get()->pluck('shortened_url');

            /**
             * Be sure to remove links from cache
             */
            foreach ($expiredUrls as $url) {
                Cache::forget($url);
            }

            /**
             * delete links
             */
            Url::whereIn('shortened_url', $expiredUrls)->delete();
        } catch (Exception $ex) {
            $this->error($ex->getMessage());
        }
    }
}
