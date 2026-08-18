<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TestimonialRequest;
use App\Models\Testimonial;
use App\Support\PublicUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Throwable;

class TestimonialController extends Controller
{
    public function index(): View
    {
        return view('admin.testimonials.index', [
            'testimonials' => Testimonial::query()->orderBy('sort_order')->orderBy('name')->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.testimonials.create');
    }

    public function store(TestimonialRequest $request): RedirectResponse
    {
        $data = Arr::except($request->validated(), ['photo', 'remove_photo']);
        $newPhoto = null;

        try {
            if ($request->hasFile('photo')) {
                $newPhoto = PublicUpload::store($request->file('photo'), 'testimonials');
                $data['photo'] = $newPhoto;
            }

            Testimonial::query()->create($data);
        } catch (Throwable $exception) {
            PublicUpload::delete($newPhoto);

            throw $exception;
        }

        return to_route('admin.testimonials.index')->with('success', 'Testimoni berhasil ditambahkan.');
    }

    public function edit(Testimonial $testimonial): View
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(TestimonialRequest $request, Testimonial $testimonial): RedirectResponse
    {
        $data = Arr::except($request->validated(), ['photo', 'remove_photo']);
        $newPhoto = null;
        $oldPhoto = null;

        try {
            if ($request->hasFile('photo')) {
                $newPhoto = PublicUpload::store($request->file('photo'), 'testimonials');
                $data['photo'] = $newPhoto;
                $oldPhoto = $testimonial->photo;
            } elseif ($request->boolean('remove_photo')) {
                $data['photo'] = null;
                $oldPhoto = $testimonial->photo;
            }

            $testimonial->update($data);
        } catch (Throwable $exception) {
            PublicUpload::delete($newPhoto);

            throw $exception;
        }

        PublicUpload::delete($oldPhoto);

        return to_route('admin.testimonials.index')->with('success', 'Testimoni berhasil diperbarui.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $photo = $testimonial->photo;
        $testimonial->delete();
        PublicUpload::delete($photo);

        return to_route('admin.testimonials.index')->with('success', 'Testimoni berhasil dihapus.');
    }
}
