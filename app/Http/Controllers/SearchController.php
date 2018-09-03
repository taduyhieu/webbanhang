<?php

namespace Fully\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Fully\Models\News;
use View;
use Search;
use Fully\Services\Pagination;

/**
 * Class SearchController.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
class SearchController extends Controller
{
    protected $perPage;

    public function __construct()
    {
        $this->perPage = config('fully.per_page');
    }

    public function index(Request $request)
    {
        $searchTitle = $request->get('search');
        $news = News::where('news_title', 'like', '%' . $searchTitle . '%')->paginate(10);
        return view('frontend.search.index', compact('news', 'searchTitle'));
    }
}
