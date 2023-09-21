<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Post;
use App\Models\Video;
use Illuminate\Http\Request;
 
class SearchController extends Controller
{
    // multiple-models-search-one-collection-with-pagination

    public function __invoke(Request $request)
    {
        $posts = Post::where('title', 'like', '%' . $request->input('query') . '%')->get();
        $courses = Course::where('title', 'like', '%' . $request->input('query') . '%')->get();
        $videos = Video::where('title', 'like', '%' . $request->input('query') . '%')->get();

        $results = collect(); 
 
        $results->push($posts, $courses, $videos); 
         $results->flatten()->paginate();
         return $results->withQueryString()->links();
        // return view('search', ['results' => $results->flatten()]); 
    }
}