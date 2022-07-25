<?php

namespace App\Http\Controllers;

use App\Http\Requests\SummarizeRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SummarizesController extends Controller
{
    public function index()
    {
        return view('summarize.index');
    }

    public function detect(SummarizeRequest $request)
    {
        try {
            $data = $request->validated();
            $response = Http::withHeaders(
                [
                    'X-RapidAPI-Host'=>'text-summarizer1.p.rapidapi.com',
                    'X-RapidAPI-Key'=>' 0db591ca40mshe5dd63107024cd7p16a693jsn3afb2fc80e9e',
                    'content-type'=>'application/json'
                ]
            )->post("https://text-summarizer1.p.rapidapi.com/summarize", $data);
            $newRes = json_decode($response, true);
            $response = Config('paraphrase');
            session()->flashInput($request->input());
            $string = Str::of($response['rewrite'])->explode(' ');
            $countRequest = Str::of($request->text)->explode(' ')->count();
            $count = $string->count();
            return view('summarize.index',
                compact('response', 'count', 'countRequest'))
                ->withInput($request->only('text'));
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
}
