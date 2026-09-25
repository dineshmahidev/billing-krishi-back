<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LandingContent;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    public function landing()
    {
        return response()->json(LandingContent::current());
    }

    public function updateLanding(Request $request)
    {
        if (!$request->user()->isAdmin()) return response()->json(['message' => 'Forbidden - Admin only'], 403);
        if ($request->user()->is_demo) return response()->json(['message' => 'Demo mode: landing page is read-only'], 403);
        $data = $request->validate([
            'hero_badge' => 'sometimes|string|max:255',
            'hero_title' => 'sometimes|string|max:255',
            'hero_highlight' => 'sometimes|string|max:100',
            'hero_desc' => 'sometimes|nullable|string|max:1000',
            'about_title' => 'sometimes|string|max:255',
            'about_desc' => 'sometimes|nullable|string|max:2000',
            'contact_phone' => 'sometimes|string|max:50',
            'contact_email' => 'sometimes|nullable|email|max:255',
            'contact_address' => 'sometimes|nullable|string|max:1000',
            'contact_hours' => 'sometimes|nullable|string|max:255',
            'hero_image' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'about_image' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $content = LandingContent::current();

        foreach (['hero_image','about_image'] as $imgField) {
            if ($request->hasFile($imgField)) {
                $path = $request->file($imgField)->store('cms','public');
                $data[$imgField] = 'storage/'.$path;
            }
        }

        $content->update($data);
        return response()->json($content);
    }
}
