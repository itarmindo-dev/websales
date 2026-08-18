<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TruckModelRequest;
use App\Models\TruckModel;
use App\Support\PublicUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Throwable;

class TruckModelController extends Controller
{
    public function index(): View
    {
        return view('admin.truck-models.index', [
            'truckModels' => TruckModel::query()->orderBy('sort_order')->orderBy('name')->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.truck-models.create');
    }

    public function store(TruckModelRequest $request): RedirectResponse
    {
        $data = Arr::except($request->validated(), ['image', 'remove_image']);
        $newImage = null;

        try {
            if ($request->hasFile('image')) {
                $newImage = PublicUpload::store($request->file('image'), 'truck-models');
                $data['image'] = $newImage;
            }

            TruckModel::query()->create($data);
        } catch (Throwable $exception) {
            PublicUpload::delete($newImage);

            throw $exception;
        }

        return to_route('admin.truck-models.index')->with('success', 'Model truk berhasil ditambahkan.');
    }

    public function edit(TruckModel $truckModel): View
    {
        return view('admin.truck-models.edit', compact('truckModel'));
    }

    public function update(TruckModelRequest $request, TruckModel $truckModel): RedirectResponse
    {
        $data = Arr::except($request->validated(), ['image', 'remove_image']);
        $newImage = null;
        $oldImage = null;

        try {
            if ($request->hasFile('image')) {
                $newImage = PublicUpload::store($request->file('image'), 'truck-models');
                $data['image'] = $newImage;
                $oldImage = $truckModel->image;
            } elseif ($request->boolean('remove_image')) {
                $data['image'] = null;
                $oldImage = $truckModel->image;
            }

            $truckModel->update($data);
        } catch (Throwable $exception) {
            PublicUpload::delete($newImage);

            throw $exception;
        }

        PublicUpload::delete($oldImage);

        return to_route('admin.truck-models.index')->with('success', 'Model truk berhasil diperbarui.');
    }

    public function destroy(TruckModel $truckModel): RedirectResponse
    {
        $image = $truckModel->image;
        $truckModel->delete();
        PublicUpload::delete($image);

        return to_route('admin.truck-models.index')->with('success', 'Model truk berhasil dihapus.');
    }
}
