<?php

namespace App\Http\Controllers;

use App\Actions\Titles\Store\StoreTitleData;
use App\Http\Requests\VideoLinkManagementStoreRequest;
use App\Models\Title;
use Common\Core\BaseController;
use Illuminate\Http\Request;
class VideoLinkManagementController extends BaseController
{

    public function store(VideoLinkManagementStoreRequest $request)
    {
        $data = $request->validated();

        $options = [];


        $title = Title::where('id', $data['title_id'])->first();

        if (is_null($title)) {
            return response()->json([
                'data' => $title
            ]);
        }

        $linksCount = $title->videos()->count();

        if ($data['platform'] === 'api') {
            $title->update(['name' =>  $request->clean_title]);
            $title->refresh();
        }

        if ($linksCount < 5 || $data['platform'] === 'api') {
            $data['name'] = $title->name;
            $options = $this->formatOptions($options, $data);
            $title->videos()->createMany($options['videos']);
        }


//        $data['videos'] = $options['videos'];
//
//        unset($options['videos']);
//
//        $options['user_id'] = $request->user()->id;
//
//        $title = app(StoreTitleData::class)->execute(
//            new Title(),
//            $this->formatData($data),            dd($options);
//            $options
//        );

        $title->load('videos');

        return response()->json([
            'data' => $title
        ]);
    }

    public function searchTitle(Request $request)
    {
        $title = Title::where(function ($query) use ($request) {
            return $query->where("name", "like", "%{$request->clean_title}%");
        })->first();

        return response()->json(['data' => $title]);
    }


    public function index()
    {
        //Need modification on that only user related titles and also add filters
        return response()->json([
            'data' => Title::with('videos')->get()
        ]);
    }


    public function show(int $id)
    {
        //need modification on that this should only user related videos.
        return response()->json([
            'data' =>  Title::with('videos')->where('id', $id)->first() ?? []
        ]);
    }

    public function delete(int $id)
    {
        //need modification this should only user related videos.
        $title = Title::findOrFail($id);

        $title->videos()->delete();
        $title->delete();

        return response()->json([
            'data' => []
        ]);
    }

    /**
     * @param array $data
     * @return array
     */
    private function formatData(array $data): array
    {
        if ($data['id_type'] ===  Title::IMDB_MEDIUM) {
            $data['imdb_id'] = $data['id'];
        }

        if ($data['id_type'] ===  Title::TMDB_MEDIUM) {
            $data['tmdb_id'] = $data['id'];
        }

        if ($data['type'] === Title::SERIES_TYPE) {
            $data['is_series'] = 1;
        }

        $data['approved'] = 0;

        unset($data['id'], $data['id_type']);

        return $data;
    }

    /**
     * @param array $data
     * @param array $requestData
     * @return array
     */
    private function formatOptions(array $data, array $requestData): array
    {
        foreach ($requestData['src'] as $key => $src) {
            $data['videos'][] = [
                'name' => $requestData['name'] . '-video-' . $key,
                'type' => $requestData['video_type'],
                'category' => $requestData['video_category'],
                'src' => $src,
                'quality' => $requestData['quality']
            ];
        }

        return $data;
    }
}
