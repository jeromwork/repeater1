<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoController extends Controller
{
//    public function store(StoreVideoRequest $request)
//    {
//        $video = Video::create([
//            'disk'          => 'videos_disk',
//            'original_name' => $request->video->getClientOriginalName(),
//            'path'          => $request->video->store('videos', 'videos_disk'),
//            'title'         => $request->title,
//        ]);
//
//        $this->dispatch(new ConvertVideoForDownloading($video));
//        $this->dispatch(new ConvertVideoForStreaming($video));
//
//        return response()->json([
//            'id' => $video->id,
//        ], 201);
//    }
    public function store(StoreVideoRequest $request)
    {
        $path = Str::random(16) . '.' . $request->video->getClientOriginalExtension();
        $request->video->storeAs('public', $path);

        $video = Video::create([
            'disk'          => 'videos_disk',
            'original_name' => $request->video->getClientOriginalName(),
            'path'          => $request->video->store('videos', 'videos_disk'),
            'title'         => $request->title,
        ]);

        $this->dispatch(new ConvertVideoForDownloading($video));
        $this->dispatch(new ConvertVideoForStreaming($video));

        return response()->json([
            'id' => $video->id,
        ], 201);
    }
}
