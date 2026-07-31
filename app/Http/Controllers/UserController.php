<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display the user management page.
     */
    public function index(): View
    {
        return view('users.index');
    }

    /**
     * Dashboard statistics (AJAX).
     */
    public function statistics(): JsonResponse
    {
        $today = now()->startOfDay();

        return response()->json([
            'success' => true,
            'data'    => [
                'total'      => User::count(),
                'verified'   => User::whereNotNull('email_verified_at')->count(),
                'unverified' => User::whereNull('email_verified_at')->count(),
                'today'      => User::where('created_at', '>=', $today)->count(),
            ],
        ]);
    }

    /**
     * Server-side data for Bootstrap Table.
     */
    public function data(Request $request): JsonResponse
    {
        $query = User::query();

        // Global search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Email verification filter
        $emailStatus = $request->input('email_status');
        if ($emailStatus === 'verified') {
            $query->whereNotNull('email_verified_at');
        } elseif ($emailStatus === 'unverified') {
            $query->whereNull('email_verified_at');
        }

        // Date filter
        $dateFilter = $request->input('date_filter');
        if ($dateFilter === 'today') {
            $query->whereDate('created_at', today());
        } elseif ($dateFilter === 'this_week') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($dateFilter === 'this_month') {
            $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
        } elseif ($dateFilter === 'custom') {
            if ($from = $request->input('date_from')) {
                $query->whereDate('created_at', '>=', $from);
            }
            if ($to = $request->input('date_to')) {
                $query->whereDate('created_at', '<=', $to);
            }
        }

        // Sorting
        $sort  = $request->input('sort', 'id');
        $order = strtolower($request->input('order', 'desc')) === 'asc' ? 'asc' : 'desc';
        $allowed = ['id', 'name', 'email', 'email_verified_at', 'created_at', 'updated_at'];

        if (in_array($sort, $allowed, true)) {
            $query->orderBy($sort, $order);
        } else {
            $query->orderBy('id', 'desc');
        }

        $total  = $query->count();
        $limit  = max(1, min(100, (int) $request->input('limit', 10)));
        $offset = max(0, (int) $request->input('offset', 0));

        $rows = $query->skip($offset)->take($limit)->get()->map(function (User $u) {
            return [
                'id'               => $u->id,
                'name'             => $u->name,
                'email'            => $u->email,
                'email_verified'   => $u->email_verified_at !== null,
                'email_verified_at'=> $u->email_verified_at?->format('M d, Y h:i A'),
                'created_at'       => $u->created_at?->format('M d, Y h:i A'),
                'updated_at'       => $u->updated_at?->format('M d, Y h:i A'),
                'created_at_raw'   => $u->created_at?->toIso8601String(),
            ];
        });

        return response()->json([
            'total' => $total,
            'rows'  => $rows,
        ]);
    }

    /**
     * Show a single user (AJAX – View modal).
     */
    public function show(int $id): JsonResponse
    {
        $user = User::findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => [
                'id'               => $user->id,
                'name'             => $user->name,
                'email'            => $user->email,
                'email_verified'   => $user->email_verified_at !== null,
                'email_verified_at'=> $user->email_verified_at?->format('M d, Y h:i A'),
                'created_at'       => $user->created_at?->format('M d, Y h:i A'),
                'updated_at'       => $user->updated_at?->format('M d, Y h:i A'),
            ],
        ]);
    }

    /**
     * Store a new user (AJAX).
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = User::create([
            'name'     => $request->validated('name'),
            'email'    => $request->validated('email'),
            'password' => Hash::make($request->validated('password')),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully.',
            'data'    => ['id' => $user->id],
        ], 201);
    }

    /**
     * Update an existing user (AJAX).
     */
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $data = [
            'name'  => $request->validated('name'),
            'email' => $request->validated('email'),
        ];

        if ($request->boolean('change_password') && $request->filled('password')) {
            $data['password'] = Hash::make($request->validated('password'));
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully.',
        ]);
    }

    /**
     * Delete a user (AJAX).
     */
    public function destroy(int $id): JsonResponse
    {
        $user = User::findOrFail($id);

        // Optional: prevent deleting yourself if auth is in place
        // if (auth()->id() === $user->id) { ... }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully.',
        ]);
    }
}
