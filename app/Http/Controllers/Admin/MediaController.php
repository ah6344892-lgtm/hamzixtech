<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaAsset;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', MediaAsset::class);
        return view('admin.media.index', ['assets'=>MediaAsset::query()->with('uploader')->latest()->paginate(24)]);
    }

    public function store(Request $request)
    {
        Gate::authorize('create', MediaAsset::class);
        $data = $request->validate(['file'=>['required','image','mimes:jpg,jpeg,png,webp','max:5120'],'alt_text'=>['nullable','string','max:255']]);
        $file = $data['file'];
        $path = $file->store('media','public');
        $asset = MediaAsset::query()->create([
            'uploaded_by'=>$request->user()->id,
            'disk'=>'public',
            'path'=>$path,
            'original_name'=>mb_substr(basename($file->getClientOriginalName()),0,255),
            'mime_type'=>$file->getMimeType(),
            'size_bytes'=>$file->getSize(),
            'alt_text'=>$data['alt_text'] ?? null,
        ]);
        ActivityLogger::record('media.uploaded',$asset,'Uploaded media');
        return back()->with('success','Image uploaded.');
    }

    public function destroy(MediaAsset $asset)
    {
        Gate::authorize('delete',$asset);
        Storage::disk($asset->disk)->delete($asset->path);
        $asset->delete();
        ActivityLogger::record('media.deleted',$asset,'Deleted media asset');
        return back()->with('success','Media asset deleted.');
    }
}
