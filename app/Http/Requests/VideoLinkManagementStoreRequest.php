<?php

namespace App\Http\Requests;

use App\Rules\IsValidDomain;
use Common\Core\BaseFormRequest;

class VideoLinkManagementStoreRequest extends BaseFormRequest
{

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'type' => ['required', 'string', 'in:movie,series'],
            'id' => ['required', 'string', 'max:50'],
            'id_type' => ['required', 'in:imdb,tmdb,iwo'],
            'api_key' => ['required', 'string', 'max:240'],
            'language' => ['nullable', 'string', 'size:2'],
            'videos' => ['required', 'array'],
            'videos.*.name' => ['nullable', 'string', 'max:200'],
            'videos.*.quality' => ['required', 'string', 'in:sd,hd,720p,1080p,4k'],
            'videos.*.src' => ['required', 'url', new IsValidDomain()],
            'videos.*.type' => ['required', 'string', 'in:embed,url,direct'],
            'videos.*.category' => ['required', 'string', 'in:trailer,clip,movie,episode']
        ];
    }
}
