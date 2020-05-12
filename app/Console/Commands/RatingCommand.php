<?php

namespace App\Console\Commands;

use App\Lesson;
use App\Group;
use App\Schedule;
use App\Plan;
use App\DateConvert;
use Illuminate\Console\Command;

class RatingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rating:group {group}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill rating';

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
        foreach (Plan::where('group_id', $this->argument('group'))->get() as $key => $plan) {
            $this->info($plan->subject->name);
            $plan->generateResults();
            //$plan->generateRatings();
        }
    }
}
