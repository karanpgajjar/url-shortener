<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShortUrlRequest;
use Illuminate\Http\Request;
use App\Models\ShortUrl;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{
    public function store(StoreShortUrlRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->authorize("create", ShortUrl::class);

        $shortUrl = ShortUrl::create([
            "code" => $this->generateUniqueCode(),
            "original_url" => $request->validated()["original_url"],
            "user_id" => $request->user()->id,
            "company_id" => $request->user()->company_id,
        ]);

        return response()->json([
            "message" => "Short URL created: " . url("/s/" . $shortUrl->code),
            "reload" => true,
        ]);
    }


    public function redirect(string $code)
    {
        $shortUrl = ShortUrl::where("code", $code)->firstOrFail();
        $shortUrl->increment("clicks");
        return Redirect::away($shortUrl->original_url);
    }


    private function generateUniqueCode()
    {
        do {
            $code = Str::random(7);
        } while (ShortUrl::where("code", $code)->exists());

        return $code;
    }
}
