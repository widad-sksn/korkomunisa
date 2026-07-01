<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    public function impersonate(User $user)
    {
        // Prevent impersonating oneself or another admin if desired, but we just prevent oneself
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat login sebagai diri sendiri.');
        }

        $adminId = auth()->id();
        $adminName = auth()->user()->name;

        // Log the action
        \Illuminate\Support\Facades\Log::info("Admin {$adminName} (ID: {$adminId}) has started impersonating user {$user->name} (ID: {$user->id})");

        // Store original admin ID in session
        session()->put('impersonate_by', $adminId);

        // Login as the user
        auth()->login($user);

        return redirect()->route('dashboard')->with('success', "Anda sekarang masuk sebagai {$user->name}.");
    }

    public function leaveImpersonate()
    {
        if (session()->has('impersonate_by')) {
            $adminId = session()->pull('impersonate_by');
            
            // Log the action
            $currentUserId = auth()->id();
            \Illuminate\Support\Facades\Log::info("Admin (ID: {$adminId}) stopped impersonating user (ID: {$currentUserId}) and returned to admin account");

            // Logout current user (the impersonated one)
            auth()->logout();

            // Login back as the admin
            auth()->loginUsingId($adminId);

            return redirect()->route('admin.users.index')->with('success', 'Berhasil kembali ke akun Admin.');
        }

        return redirect()->route('dashboard');
    }
}
