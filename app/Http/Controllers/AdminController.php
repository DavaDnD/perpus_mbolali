<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function users(Request $request)
    {
        $query = User::query();

        // Filter by role
        if ($request->has('role') && $request->role !== '') {
            $query->where('role', $request->role);
        }

        // Filter by status (online/offline)
        if ($request->has('status') && $request->status !== '') {
            $allUsers = User::all();
            if ($request->status === 'online') {
                $onlineUserIds = $allUsers->filter(fn($u) => $u->isOnline())->pluck('id')->toArray();
                $query->whereIn('id', $onlineUserIds);
            } elseif ($request->status === 'offline') {
                $offlineUserIds = $allUsers->filter(fn($u) => !$u->isOnline())->pluck('id')->toArray();
                $query->whereIn('id', $offlineUserIds);
            }
        }

        // Search functionality
        if ($request->has('q') && $request->q != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%')
                    ->orWhere('email', 'like', '%' . $request->q . '%');
            });
        }

        $users = $query->paginate(10);

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->has('q') || $request->has('role') || $request->has('status')) {
            return response()->json([
                'rows' => view('admin.users.partials.rows', compact('users'))->render(),
                'pagination' => view('admin.users.partials.pagination', compact('users'))->render(),
                'total' => $users->total()
            ]);
        }

        return view('admin.users.index', compact('users'));
    }

    // Show single user (untuk edit modal)
    public function show(User $user)
    {
        return response()->json($user);
    }

    // Store new user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:Admin,Officer,Member',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $currentUser = auth()->user();

        // Admin cannot un-admin themselves
        if ($user->id === $currentUser->id && $user->role === 'Admin' && $request->role !== 'Admin') {
            return response()->json([
                'error' => 'You cannot remove your own Admin role.'
            ], 422);
        }

        // Officer cannot change roles
        if ($currentUser->role === 'Officer' && $request->role !== $user->role) {
            return response()->json([
                'error' => 'You are not authorized to change user roles.'
            ], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|in:Admin,Officer,Member',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }

    // Delete selected users (bulk delete)
    public function destroySelected(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id'
        ]);

        $currentUser = auth()->user();

        // Prevent deleting yourself
        if (in_array($currentUser->id, $request->ids)) {
            return response()->json([
                'error' => 'You cannot delete yourself.'
            ], 422);
        }

        // Officer can only delete Members
        if ($currentUser->role === 'Officer') {
            $usersToDelete = User::whereIn('id', $request->ids)->get();
            foreach ($usersToDelete as $user) {
                if ($user->role !== 'Member') {
                    return response()->json([
                        'error' => 'You can only delete Members.'
                    ], 403);
                }
            }
        }

        User::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message' => count($request->ids) . ' user(s) deleted successfully'
        ]);
    }

    // Get online status for all users
    public function onlineStatus()
    {
        $users = User::all();
        $status = [];

        foreach ($users as $user) {
            $status[$user->id] = $user->isOnline();
        }

        return response()->json($status);
    }
}
