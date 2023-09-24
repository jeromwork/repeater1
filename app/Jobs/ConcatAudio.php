<?php

namespace App\Jobs;

use FFMpeg;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ConcatAudio implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $file1;
    private $file2;
    private $count;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file1, $file2, $count = 5)    {
        $this->file1 = $file1;
        $this->file2 = $file2;
        $this->count = $count;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {

        $handler = FFMpeg::fromDisk('my_files')
            ->open([$this->file1, $this->file2, $this->file1, $this->file2, $this->file1, $this->file2])
            ->export();

        $handler->concatWithoutTranscoding();

        $handler->save('concat.mp3');

    }
}
