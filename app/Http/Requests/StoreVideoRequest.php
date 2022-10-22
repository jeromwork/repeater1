<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required'],
            //'video' => ['required', 'file|mimetypes:video/mp4,video/mpeg,video/x-matroska'],
            'video' => ['required', 'file'],
        ];
    }
}
