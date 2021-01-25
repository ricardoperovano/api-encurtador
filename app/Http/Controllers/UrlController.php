<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;

class UrlController extends Controller
{

    /**
     * Return a list of shortned urls
     * 
     */
    public function index()
    {
    }

    /**
     * Redirects to the shortner shortned
     * 
     * @param string $shortned
     */
    public function get($shortned)
    {
        $url = Url::where('url', $shortned)->first();

        if ($url) {
            redirect()->to($url->url);
        }

        abort(404);
    }

    /**
     * Add new shortner url
     * 
     * @return Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //pattern for user optional shortened url
        $regex = '/^[a-zA-Z\d]+$/';

        /**
         * validate request
         * 1 - Original url
         * 2 - Optional shortened_url (accepts only letters and numbers)
         */
        $this->validate($request, [
            'original_url'  => 'required|url',
            'shortened_url'  => "regex:$regex|max:6|unique:urls,url"
        ]);
    }
}
