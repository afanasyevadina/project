<?php

namespace App\Console\Commands;

use App\Lesson;
use App\Group;
use App\Schedule;
use App\Plan;
use App\DateConvert;
use Illuminate\Console\Command;

class AttestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attest:group {group}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Random rating';

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
        foreach ($group->students as $student) {
            foreach($student->ratings as $rating) {
                $rating->value = $rating->lesson->date ? random_int(4, 5) : null;
                $rating->save();
            }
            foreach($student->results as $result) {
                $res = random_int(4, 5);
                $result->att = $res;
                $result->itog = $res;
                if($result->plan->is_exam) $result->exam = $res;
                if($result->plan->is_zachet) $result->zachet = $res;
                if($result->plan->is_project) $result->project = $res;
                $result->save();
            }
        }
    }
}
