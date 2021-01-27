<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Services\UrlService;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class UrlController extends Controller
{

    private $urlService;

    use ApiResponser;

    //Inject url service to controller
    public function __construct(UrlService $urlService)
    {
        $this->middleware('auth:api', ['only'    => 'index']);
        $this->urlService = $urlService;
    }

    /**
     * Return a list of shortned urls
     * 
     */
    public function index()
    {
        /**
         * retun urls with pagination links
         */
        $urls = Url::paginate(10);

        return $this->successResponse($urls);
    }

    /**
     * Redirects to the shortner shortned
     * 
     * @param string $shortned
     */
    public function get($shortened)
    {
        /** 
         * Get url direct from cache
         * it will be available for 7 days
         */
        $url = Cache::get($shortened);

        if ($url) {
            return redirect()->to($url);
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
         * verify if user input shortened url is already created
         */
        if ($request->shortened_url && Cache::has($request->shortened_url)) {
            return $this->errorResponse([
                'global'   => 'url não está disponível'
            ]);
        }

        /**
         * validate request
         * 1 - Original url must be a valid url (max length of 180, but this rule could be removed)
         * 2 - Optional shortened_url (unique, accepts only letters and numbers max length of 10)
         */
        $this->validate($request, [
            'original_url'  => 'required|url|max:180',
            'shortened_url'  => 'regex:' . $regex . '|max:10|unique:urls,shortened_url'
        ]);

        /**
         * verify if url is cached
         */
        if ($request->original_url && Cache::has($request->original_url)) {
            return $this->successResponse([
                'url' => env('APP_URL') . '/' . Cache::get($request->original_url)
            ], Response::HTTP_OK);
        }

        try {

            $url = new Url();
            $url->fill(request()->all());

            //if user didn't pass any shortened url
            //create a new one
            if (!$url->shortened_url) {

                //get shortened url form url service
                $randomUrl = $this->urlService->getShortenedUrl($request->original_url);

                $url->setShortenedUrl($randomUrl);
            } else {
                $url->setShortenedUrl($request->shortened_url);
                //cache user custom shortened url
                $this->urlService->cacheUrl($request->shortened_url, $request->original_url);
            }

            $url->save();

            return $this->successResponse(['url' => $url->shortened_url], Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->errorResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
