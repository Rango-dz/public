<?php

namespace App\Http\Controllers;

use App\Actions\Titles\Store\StoreTitleData;
use App\Http\Requests\VideoLinkManagementStoreRequest;
use App\Models\Title;
use Common\Core\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

        $data['links_count'] = $linksCount;

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
        // type='movie' for movies
        // type='tv' for tv series
        $isEpisodeSearch = !empty($request->type) && $request->type === 'tv';

        if ($isEpisodeSearch) {
            if (empty($request->season) || empty($request->episode)) {
                // both season and episode should be set for episode search
                return response()->json(['info' => 'When searching TV show, both season and episode are required']);
            }
        }

        $conditions = [];

        if (!empty($request->clean_title)) {
            //$conditions[] = ["name", "like", "%{$request->clean_title}%"];
            $titleWords = explode(' ', $request->clean_title);
            foreach ($titleWords as $titleWord) {
                $conditions[] = ["name", "like", "%{$titleWord}%"];
            }
        } else if (!empty($request->id)) {
            if (!is_numeric($request->id)) {
                return response()->json(['info' => 'Search by ID is only allowed with integer "id"']);
            }
            $conditions[] = ["id", "=", $request->id];
        } else {
            return response()->json(['info' => 'Either "id" or "clean_title" is required for search']);
        }

        $conditions[] = ["is_series", "=", (int)$isEpisodeSearch];
        try {
            $title = Title::where(function ($query) use ($conditions) {
                return $query->where($conditions);
            })->first();
        } catch (\Exception $e) {
            return response()->json(['info' => 'Something went wrong while processing your request']);
        }

        if ($isEpisodeSearch && !empty($title)) {
            try {
                $episode = $title->episodes()
                    ->where('season_number', (int)$request->season)
                    ->where('episode_number', (int)$request->episode)
                    ->first();
            } catch (\Exception $e) {
                if (strpos($e->getMessage(), 'No query results for model') !== false) {
                    $episode = null;
                } else {
                    return response()->json(['info' => 'Something went wrong while searching for episode']);
                }
            }

            // searching for TV show, filter the episode's year
            if (!empty($episode) && !empty($request->year) && (int)$episode->release_date->year !== (int)$request->year) {
                $episode = null;
            }

            // if episode is not found, reset all results, explain what happened
            if (!$episode) {
                return response()->json(['info' => 'TV show is found, but episode is not']);
            } else {
                return response()->json(['data' => $title, 'episode' => $episode]);
            }
        } else if (!empty($title)) {
            // searching for movie, filter the movie's year
            if (!empty($request->year) && (int)$title->release_date->year !== (int)$request->year) {
                $title = null;
            }
        }

        if ($isEpisodeSearch && empty($title)) {
            return response()->json(['info' => 'TV show is not found']);
        } else if (empty($title)) {
            return response()->json(['info' => 'Movie is not found']);
        } else if (!empty($title)) {
            return response()->json(['data' => $title]);
        }
    }


    public function index()
    {
        Log::info("sssssssssssssssssssssssssssssss");
        //Need modification on that only user related titles and also add filters
        return response()->json([
            'data' => Title::with('videos')->get()
        ]);
    }


    public function show(int $id)
    {
        Log::info("BBBBBBBBBBBBBBBBBBBBBBBB");
        //need modification on that this should only user related videos.
        return response()->json([
            'data' =>  Title::with('videos')->where('id', $id)->first() ?? []
        ]);
    }

    public function delete(int $id)
    {
        Log::info("cCCCCCCCCCCCCCCCCCCCCCCC");
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
        $count = $requestData['links_count'] + 1;

        foreach ($requestData['src'] as $src) {
            $data['videos'][] = [
                'name' => $requestData['name'] . '-video-' . $count,
                'video_type' => $requestData['video_type'],
                'category' => $requestData['category'],
                'src' => $src,
                'quality' => $requestData['quality'],
                'season_num' => !empty($requestData['season_num']) ? $requestData['season_num'] : null,
                'episode_num' => !empty($requestData['episode_num']) ? $requestData['episode_num'] : null,
                'episode_id' => !empty($requestData['episode_id']) ? $requestData['episode_id'] : null,
            ];

            $count = $count + 1;
        }

        return $data;
    }
}
