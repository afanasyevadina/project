<?php

namespace App\Console\Commands;

use App\Lesson;
use App\Group;
use App\Schedule;
use App\Plan;
use App\DateConvert;
use Illuminate\Console\Command;

class ScheduleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:changes';

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
        file_put_contents('hello.txt', 'bye');
        $date = date('Y-m-d');
        foreach (Group::all() as $key => $group) {
            if(Lesson::where('group_id', $group->id)->where('date', $date)->exists()) continue;
            $convert = DateConvert::convert($date, $group->id);
            $year = @$convert['year'];
            $semestr = @$convert['semestr'];        
            $day = @$convert['day'];        
            $week = @$convert['week'];
            $schedule = Schedule::where('group_id', $group->id)
            ->where('year', $year)
            ->where('semestr', $semestr)
            ->where('day', $day)
            ->whereIn('week', [0, $week])
            ->get();
            foreach($schedule as $item) {
                if($item->plan->checkNext($date)) {
                    $next = $item->plan->lessons()->whereNull('date')->orderBy('order', 'asc')->first();
                    if($next) {
                        $next->date = $date;
                        $next->cab_id = $item->cab_id;
                        $next->num = $item->num;
                        $next->teacher_id = $item->plan->teacher_id;
                        $next->save();
                    }
                }
            }
        }
    }
}
