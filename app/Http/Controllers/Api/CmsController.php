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
            'stat1_value' => 'sometimes|nullable|string|max:50',
            'stat1_label' => 'sometimes|nullable|string|max:100',
            'stat2_value' => 'sometimes|nullable|string|max:50',
            'stat2_label' => 'sometimes|nullable|string|max:100',
            'stat3_value' => 'sometimes|nullable|string|max:50',
            'stat3_label' => 'sometimes|nullable|string|max:100',
            'stat4_value' => 'sometimes|nullable|string|max:50',
            'stat4_label' => 'sometimes|nullable|string|max:100',
            'about_title' => 'sometimes|string|max:255',
            'about_desc' => 'sometimes|nullable|string|max:2000',
            'contact_phone' => 'sometimes|string|max:50',
            'contact_email' => 'sometimes|nullable|email|max:255',
            'contact_address' => 'sometimes|nullable|string|max:1000',
            'contact_hours' => 'sometimes|nullable|string|max:255',
            'map_embed_url' => 'sometimes|nullable|string|max:2000',
            'hero_image' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'about_image' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        if (isset($data['map_embed_url'])) {
            $raw = trim((string)$data['map_embed_url']);
            if (preg_match('/src=["\']([^"\']+)["\']/i', $raw, $m)) {
                $data['map_embed_url'] = $m[1];
            } elseif (str_contains($raw, 'maps.app.goo.gl')) {
                $data['map_embed_url'] = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3916.3589961733287!2d77.5525126!3d11.0116687!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba9a180a88cb8a7%3A0xba96d3fb508d6259!2sKrishi%20Analytical%20Lab!5e0!3m2!1sen!2sin!4v1790512063225!5m2!1sen!2sin';
            }
        }

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
