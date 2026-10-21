<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    // Public — website landing page
    public function index()
    {
        return response()->json(Testimonial::active()->ordered()->get());
    }

    // Admin — includes inactive rows
    public function adminIndex(Request $request)
    {
        if ($err = $this->guard($request)) return $err;
        return response()->json(Testimonial::ordered()->get());
    }

    public function store(Request $request)
    {
        if ($err = $this->guard($request)) return $err;
        $testimonial = Testimonial::create($this->validated($request, true));
        return response()->json($testimonial, 201);
    }

    public function update(Request $request, $id)
    {
        if ($err = $this->guard($request)) return $err;
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update($this->validated($request, false));
        return response()->json($testimonial);
    }

    public function destroy(Request $request, $id)
    {
        if ($err = $this->guard($request)) return $err;
        Testimonial::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted']);
    }

    private function guard(Request $request)
    {
        if (!$request->user()->isAdmin()) return response()->json(['message' => 'Forbidden - Admin only'], 403);
        if ($request->user()->is_demo) return response()->json(['message' => 'Demo mode: testimonials are read-only'], 403);
        return null;
    }

    private function validated(Request $request, bool $isCreate): array
    {
        $req = $isCreate ? 'required' : 'sometimes|required';

        return $request->validate([
            'company' => "{$req}|string|max:255",
            'type' => 'nullable|string|max:255',
            'loc' => 'nullable|string|max:255',
            'text' => "{$req}|string|max:1000",
            'rating' => "{$req}|integer|between:1,5",
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'sometimes|integer|min:0',
        ]);
    }
}
