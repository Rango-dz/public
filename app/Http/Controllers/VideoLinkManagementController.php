<?php

namespace App\Http\Controllers;

use App\Actions\Titles\Store\StoreTitleData;
use App\Http\Requests\VideoLinkManagementStoreRequest;
use App\Models\Title;
use Common\Core\BaseController;
class VideoLinkManagementController extends BaseController
{

    public function store(VideoLinkManagementStoreRequest $request)
    {
        $data = $request->validated();

        $options = [];

        $options = $this->formatOptions($options, $data);
        $options['videos']['user_id'] = $request->user()?->id;


        $title = app(StoreTitleData::class)->execute(
            new Title(),
            $this->formatData($data),
            $options
        );

        $title->load('videos');

        return response()->json([
            'data' => $title
        ]);
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
        $data['videos'] = [
            'type' => $requestData['type'],
            'name' => $requestData['name'],
            'category' => 'full'
        ];

        return $data;
    }
}
