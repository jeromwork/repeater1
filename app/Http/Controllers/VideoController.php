<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForStreaming;
use App\Models\Video;

use Illuminate\Support\Str;
use Livewire\Component;

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
            'disk'          => 'public',
            'original_name' => $request->video->getClientOriginalName(),
            'path'          => $path,
            'title'         => $request->title,
        ]);

        ConvertVideoForStreaming::dispatch($video);

        return redirect('/uploader')
            ->with(
                'message',
                'Your video will be available shortly after we process it'
            );
    }


    /**
     * Return video blade view and pass videos to it.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $videos = Video::orderBy('created_at', 'DESC')->get();
        return view('videos')->with('videos', $videos);
    }

    /**
     * Return uploader form view for uploading videos
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function uploader(){
        return view('uploader');
    }

    /**
     * Handles form submission after uploader form submits
     * @param StoreVideoRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */

}
