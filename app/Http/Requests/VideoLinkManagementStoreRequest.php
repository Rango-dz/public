<?php

namespace App\Http\Requests;

use App\Rules\IsValidDomain;
use Common\Core\BaseFormRequest;

class VideoLinkManagementStoreRequest extends BaseFormRequest
{

    public function rules(): array
    {
        return [
            'type' => ['required', 'string', 'in:movie,tv'],
            'title_id' => ['required_if:platform,web', 'integer', 'exists:titles,id'],
            // 'episode_id' => ['required_if:type,tv', 'integer', 'exists:episodes,id'],
            // 'episode_num' => ['required_if:type,tv', 'integer'],
            // 'season_num' => ['required_if:type,tv', 'integer'],
            'platform' => ['required', 'string', 'in:web,api'],
            //            'api_key' => ['required_if:platform,api', 'string', 'max:240'],
            'language' => ['nullable', 'string'],
            'quality' => ['required', 'string', 'in:sd,hd,720p,1080p,4k'],
            'video_type' => ['required', 'string', 'in:embed,url,direct,web-dl'],
            'category' => ['required', 'string', 'in:full,clip,movie,episode,trailer'],
            'src' => ['required', 'array'],
            'src.*' => ['required', 'url']
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!is_array($this->src)) {
            $src = explode(",", $this->src);
            $this->merge(['src' => $src]);
        }

        if (empty($this->type)) {
            $this->type = 'movie';
        }
    }
}
