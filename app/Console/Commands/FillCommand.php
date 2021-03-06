<?php

namespace App\Console\Commands;

use App\Lesson;
use App\Group;
use App\Schedule;
use App\Plan;
use App\DateConvert;
use Illuminate\Console\Command;

class FillCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fill:group {group}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill lessons';

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
        $group = Group::find($this->argument('group'));
        $time = strtotime($group->year_create.'-09-01');
        $end = strtotime($group->year_leave.'-07-01');
        while($time < $end) {
            $date = date('Y-m-d', $time);
            $this->call('schedule:changes', ['group' => $group->id, 'date' => $date]);
            $time += 3600*24;
        }
    }
}
