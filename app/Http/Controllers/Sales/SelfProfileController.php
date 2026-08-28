<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SalesProfileRequest;
use App\Models\SalesProfile;
use App\Services\SalesProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SelfProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $sale = $request->user()->salesProfile()->with('sections')->first();

        return view('sales.profile.edit', [
            'sale' => $sale,
        ]);
    }

    public function update(SalesProfileRequest $request, SalesProfileService $profiles): RedirectResponse
    {
        $user = $request->user();
        $sale = $user->salesProfile()->first() ?? new SalesProfile;

        DB::transaction(function () use ($profiles, $request, $sale, $user): void {
            $user->forceFill(['name' => $request->validated('name')])->save();
            $profiles->save($sale, $request, $user);
        });

        return to_route('sales.self.edit')->with('success', 'Profil Anda berhasil diperbarui.');
    }
}
