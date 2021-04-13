<?php

namespace App\Classes;

/* Dependencies */
use cebe\markdown\Markdown;
use Carbon\Carbon;

/* Eloquent */
use App\Models\News as NewsModel;

class News
{

    /**
     * Create an news.
     *
     * @param \App\Http\Requests\CreateNews $request
     *
     * @return int Created news ID.
     */
    public static function createNews(\App\Http\Requests\CreateNews $request) : int
    {
        $news = new NewsModel;

        $news->title     = $request->input('title');
        $news->body      = $request->input('content');

        $news->save();


        return $news->id;
    }

    /**
     * Update an news.
     *
     * @param \App\Http\Requests\UpdateNews $request
     *
     * @return int Updated news ID.
     */
    public static function updateNews(\App\Http\Requests\UpdateNews $request) : int
    {
        $news = NewsModel::findOrFail($request->input('id'));

        $news->title     = $request->input('title');
        $news->body      = $request->input('content');

        $news->save();



        return $news->id;
    }

    /**
     * Remove article.
     *
     * @param int $id Article ID.
     *
     * @return void
     */
    public static function removeNews(int $id)
    {
        $news = NewsModel::findOrFail($id);

        $news->delete();
    }


}