<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Requests\CreateRequest;
use App\Models\Entry;
use Alimranahmed\LaraOCR\Facades\OCR;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Storage;

class RTFEMController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('CreateForm');
    }

    public function create(CreateRequest $request)
    {
        $entry = new Entry();
        $entry->random = self::generateRandom();
        $entry->log = $request->log;
        $entry->highlights = json_encode($request->highlights);
        $entry->save();
        return inertia("CreateForm", ["random" => $entry->random]);
    }

    public function view(Request $request, $random): Response
    {
        $entry = Entry::where('random', $random)->first();
        if (is_null($entry)) {
            abort(404);
        }
        $entry->highlights = json_decode($entry->highlights);
        return Inertia::render('Show', ["entry" => $entry]);
    }

    private static function generateRandom()
    {
        $length = 4;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function test(Request $request)
    {
        dd(OCR::scan("./example.png"));
    }

    public function ocr(Request $request)
    {
        foreach ($request->allFiles() as $file) {
            $uuid = Uuid::uuid4();
            $filename = $file->getClientOriginalName();
            $fullFilename = $uuid . "_" . $filename;
            $path = $file->storeAs('public/tmpOCR', $fullFilename);
            $text = OCR::scan(str_replace('public', 'storage', $path));
            Storage::delete($path);
            return response(["text" => $text], 200);
        }
    }
}
