<?php

namespace App\Http\Requests;

use App\Rules\IsValidDomain;
use Common\Core\BaseFormRequest;

class VideoLinkManagementStoreRequest extends BaseFormRequest
{

    public function rules(): array
    {
        return [
            'title_id' => ['required_if:platform,web', 'integer', 'exists:titles,id'],
            'platform' => ['required', 'string', 'in:web,api'],
//            'api_key' => ['required_if:platform,api', 'string', 'max:240'],
            'language' => ['nullable', 'string', 'size:2'],
            'quality' => ['required', 'string', 'in:sd,hd,720p,1080p,4k'],
            'video_type' => ['required', 'string', 'in:embed,url,direct,web-dl'],
            'video_category' => ['required', 'string', 'in:trailer,clip,movie,episode'],
            'src' => ['required', 'array'],
            'src.*' => ['required', 'url']
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->src) {
            $src = explode(",", $this->src);
            $this->merge(['src' => $src]);
        }
    }
}
