<?php

namespace App\Console\Commands;

use App\Lesson;
use App\Group;
use App\Schedule;
use App\Plan;
use App\DateConvert;
use Illuminate\Console\Command;

class ResetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:group {group}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset lessons';

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
        foreach (Lesson::where('group_id', $group->id)->get() as $key => $lesson) {
            $lesson->date = null;
            $lesson->cab_id = null;
            $lesson->teacher_id = null;
            $lesson->save();
        }
    }
}
