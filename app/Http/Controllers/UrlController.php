<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UrlController extends Controller
{
    /**
     * Add new shortner url
     * 
     * @return Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //patter for user input shortened url
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

    /**
     * Redirects to the shortner url
     * 
     * @param string $url
     */
    public function get($url)
    {
    }
}
