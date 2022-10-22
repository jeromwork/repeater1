<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForDownloading;
use App\Jobs\ConvertVideoForStreaming;
use App\Jobs\ConcatAudio;
use \App\Models\Video;
use Illuminate\Http\Request;


class VideoController extends Controller
{
    public function store(StoreVideoRequest $request)
    {
        $video = Video::create([
            'disk'          => 'my_files',
            'original_name' => $request->video->getClientOriginalName(),
            'path'          => $request->video->store('videos', 'my_files'),
            'title'         => $request->title,
        ]);




        $this->dispatch(new ConvertVideoForDownloading($video));
        //$this->dispatch(new ConvertVideoForStreaming($video));

        return response()->json([
            'id' => $video->id,
        ], 201);
    }

    public function repeat()
    {

        $this->dispatch(new ConcatAudio('word_eng.mp3', 'word_ru.mp3', 5));
    }


    public function index(){
        error_log('info');
        dd('sdqwdqwd');
        return 'index22222';
    }
}
