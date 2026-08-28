<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SalesProfileRequest;
use App\Models\SalesProfile;
use App\Models\User;
use App\Services\SalesProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SalesProfileController extends Controller
{
    public function index(): View
    {
        return view('admin.sales.index', [
            'sales' => SalesProfile::query()->with('user')->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.sales.create');
    }

    public function store(SalesProfileRequest $request, SalesProfileService $profiles): RedirectResponse
    {
        DB::transaction(function () use ($request, $profiles): void {
            $owner = $this->createAccountWhenRequested($request);
            $profiles->save(new SalesProfile, $request, $owner);
        });

        return to_route('admin.sales.index')->with('success', 'Profil sales berhasil dibuat.');
    }

    public function edit(SalesProfile $sale): View
    {
        $sale->load(['user', 'sections']);

        return view('admin.sales.edit', compact('sale'));
    }

    public function update(
        SalesProfileRequest $request,
        SalesProfile $sale,
        SalesProfileService $profiles,
    ): RedirectResponse {
        DB::transaction(function () use ($request, $sale, $profiles): void {
            $owner = $sale->user ?: $this->createAccountWhenRequested($request);

            if ($owner) {
                $owner->forceFill([
                    'name' => $request->validated('name'),
                    'email' => $request->validated('account_email'),
                    'is_sales' => $request->boolean('account_enabled'),
                    'email_verified_at' => $owner->email_verified_at ?? now(),
                ]);

                if ($request->filled('account_password')) {
                    $owner->password = $request->validated('account_password');
                }

                $owner->save();
            }

            $profiles->save($sale, $request, $owner);
        });

        return to_route('admin.sales.index')->with('success', 'Profil sales berhasil diperbarui.');
    }

    public function destroy(SalesProfile $sale, SalesProfileService $profiles): RedirectResponse
    {
        $owner = $sale->user;

        DB::transaction(function () use ($owner, $profiles, $sale): void {
            if ($owner) {
                $owner->forceFill(['is_sales' => false])->save();
            }

            $profiles->delete($sale);
        });

        return to_route('admin.sales.index')->with('success', 'Profil sales dihapus dan akses akunnya dinonaktifkan.');
    }

    private function createAccountWhenRequested(SalesProfileRequest $request): ?User
    {
        if (! $request->filled('account_email')) {
            return null;
        }

        $user = new User([
            'name' => $request->validated('name'),
            'email' => $request->validated('account_email'),
            'password' => $request->validated('account_password'),
        ]);
        $user->forceFill([
            'is_sales' => $request->boolean('account_enabled'),
            'email_verified_at' => now(),
        ])->save();

        return $user;
    }
}
