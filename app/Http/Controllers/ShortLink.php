<?php

namespace App\Http\Controllers;

use App\Models\ShortLinkHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\Factory;
use Illuminate\View\View;

class ShortLink extends Controller
{

    function index(): View
    {
        $links = ShortLinkHistory::orderBy('id', 'desc')->take(10)->get();
        return app(Factory::class)->make("index", ["links" => $links->toArray()]);
    }

    function getLinks(): View
    {
        $links = ShortLinkHistory::orderBy('id', 'desc')->take(10)->get();
        return app(Factory::class)->make("last-shorts", ["links" => $links->toArray()]);
    }

    function makeShortLink(Request $request): JsonResponse
    {
        $link = $request->input('link');
        $parsed_url = parse_url($link);

        if (!key_exists("host", $parsed_url)) {
            return response()->json(["error"=> 'Bad link!!'], status: 400);
        }

        $variant = range('a', 'z');
        $next_short = 'a';

        $last_short_link = ShortLinkHistory::orderBy('id', 'desc')->first();
        if ($last_short_link) {
            $last_sign = substr($last_short_link->short_part, -1);
            $last_sign_position = array_search($last_sign, $variant);
            if ($last_sign_position + 1 < count($variant)) {
                $next_short = substr($last_short_link->short_part, 0, -1) . $variant[$last_sign_position + 1];
            } else {
                $next_short = $last_short_link->short_part . $variant[0];
            }
        }

        $short_link_history = new ShortLinkHistory;
        $short_link_history->raw_link = $link;
        $short_link_history->short_part = $next_short;
        $short_link_history->short_link = (key_exists("scheme", $parsed_url) ? $parsed_url["scheme"] . "://" : '') . $parsed_url["host"] . '/' . $next_short;
        $short_link_history->save();

        return response()->json();
    }
}
