<?php

namespace App\Console\Commands;

use App\Lesson;
use App\Group;
use App\Schedule;
use App\Plan;
use App\DateConvert;
use Illuminate\Console\Command;

class ChangesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'changes:fill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto changes';

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
        $date = date('Y-m-d');
        foreach (Group::all() as $key => $group) {
            $this->call('schedule:changes', ['group' => $group->id, 'date' => $date]);
        }
    }
}
