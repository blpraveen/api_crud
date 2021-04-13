<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* Classes */
use App\Classes\News;

/* Requests */
use App\Http\Requests\CreateNews;
use App\Http\Requests\UpdateNews;

/* Eloquent */
use App\Models\News as NewsModel;

use Carbon\Carbon;
class NewsController extends Controller
{

    /**
     * Show the listing of news.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('news.listing', [
            'news' => NewsModel::orderBy('updated_at', 'desc')
                                 ->orderBy('created_at', 'desc')
                                 ->paginate(5)
        ]);
    }

    /**
     * Show news.
     *
     * @param int $id An ID of the news.
     *
     * @return \Illuminate\Http\Response
     */
    public function view(int $id)
    {
        try {
            $news = NewsModel::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->view('news.errors.404', [], 404);
        }

       

        return view('news.view', [
            'news'        => $article
        ]);
    }

    /**
     * Show creating or updating form.
     *
     * @param int $id An ID of the article.
     *
     * @return \Illuminate\Http\Response
     */
    public function manage(int $id = null)
    {
        if ($id === null) {
            return view('news.manage');
        }

        try {
            $news = NewsModel::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->view('news.errors.404', [], 404);
        }

        return view('news.manage', [
            'news' => $article
        ]);
    }

    /**
     * Create an article and redirect user to its page.
     *
     * @param \App\Http\Requests\CreateArticle $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(CreateArticle $request)
    {
        $id = News::createNews($request);

        return redirect()->route('view_news', ['id' => $id]);
    }

    /**
     * Update or remove an article.
     *
     * If article was updated, user will be redirected to its page.
     * If article was removed, user will be redirected to listing of articles.
     *
     * @param \App\Http\Requests\UpdateArticle $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateArticle $request)
    {
        if ($request->input('remove') === 'yes') {
            News::removeNews($request->input('id'));
            return redirect()->route('listing_of_news');
        }

        $id = News::updateNews($request);

        return redirect()->route('view_news', ['id' => $id]);
    }
}