<?php

namespace App\Http\Controllers;

use App\Exports\UserExportExcel;
use App\Factories\UserExport;
use App\Factories\UserExportFactory;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
// use App\Factories\

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy tất cả người dùng
        $users = User::orderBy('created_at', 'desc')->paginate(5);

        // Trả về dữ liệu dưới dạng JSON
        return response()->json($users);
    }

    public function show($id)
    {
        $user = $this->userRepository->find($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function search(Request $request)
    {
        //
        $query = User::query();
        // Kiểm tra xem có từ khóa tìm kiếm không
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            // Tìm kiếm theo email hoặc tên người dùng
            $query->where('email', 'like', '%' . $search . '%')
                ->orWhere('name', 'like', '%' . $search . '%');
        }

        // Lấy danh sách người dùng
        $users = $query->paginate();

        return view('admin/home', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:user,admin',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imgUrl = null;

        if ($request->hasFile('img')) {
            // Delete old image if it exists
            try {
                dump("abc");
                $path = $request->file('img')->store('images', 'public');
                dump($path);
                Log::info($request->file('img')->getBasename());
                $imgUrl = $path ?? "images/ocPE29AMCEw3qXS009jRYWdGvu7RGreyKgMakMkt.png"; // Save the path of the image
            } catch (Exception $exception) {
                Log::error($exception->getMessage());
            }
            // Store the new image and get the filename
        }

        $user = $this->userRepository->create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'role' => $request['role'],
            'img'=> $imgUrl,
        ]);
        

        return redirect()->route('home')->with('status', 'User "' . $user->name . '" created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function user_update(Request $request, $id)
    {
        // Validate input fields
        $validated = $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image validation
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = $this->userRepository->find($id);
        // Update the user fields
        $user->email = $request->input('email');
        $user->name = $request->input('name');
        // Run php artisan storage:link to link 
        // Handle image upload
        if ($request->hasFile('img')) {
            // Delete old image if it exists
            if ($user->img && Storage::exists('public/' . $user->img)) {
                dd($user->img);
                Storage::delete('public/' . $user->img);
            }
            try {
                $path = $request->file('img')->store('images', 'public');
                Log::info($request->file('img')->getBasename());
                $user->img = $path; // Save the path of the image
            } catch (Exception $exception) {
                Log::error($exception->getMessage());
            }
            // Store the new image and get the filename
        }

        // Handle password update if provided
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        // Save the updated user data
        $user->save();

        // Redirect or return response
        return redirect()->route('home')->with('Your Information', 'Profile updated successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Tìm người dùng theo ID
        $user = $this->userRepository->find($id);

        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found!');
        }

        // Trả về view chỉnh sửa người dùng với dữ liệu của người dùng
        return view('users.edit', compact('user'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = $this->userRepository->find($id);

        // Xác thực dữ liệu đầu vào
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image validation
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $imgUrl = null;

        if ($request->hasFile('img')) {
            // Delete old image if it exists
            if ($user->img && Storage::exists('public/' . $user->img)) {
                Storage::delete('public/' . $user->img);
            }
            try {
                $path = $request->file('img')->store('images', 'public');
                Log::info($request->file('img')->getBasename());
                $imgUrl = $path; // Save the path of the image
            } catch (Exception $exception) {
                Log::error($exception->getMessage());
            }
            // Store the new image and get the filename
        }

        $user = $this->userRepository->admin_update($id, [
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password'],
            'role' => $request['role'],
            'img'=> $imgUrl
        ]);

        return redirect()->route('home')->with('status', 'Thông tin người dùng đã được cập nhật.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $user = $this->userRepository->delete($id);
        $message = 'successfully';
        if (!$user) $message = 'fail';

        return redirect()->route('home')->with('status', 'Deleted user ' . $message);
    }
    public function user_in_trash()
    {
        $users = User::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(5);
        $trash = 'trash';
        return view('admin/trash', compact(['users', 'trash']));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->find($id);
        if (!$user) return redirect()->route('users.trash')->with('status', 'User not found');
        $user->restore();
        Cache::forget('users');
        return redirect()->route('users.trash')->with('status', 'Restored ' . $user->name . ' successfully');
    }
    public function trash_search(Request $request)
    {
        $search = $request->search;
        $users = User::onlyTrashed()->where('email', 'like', '%' . $search . '%')
            ->orWhere('name', 'like', '%' . $search . '%')->paginate(5);
        return view('admin/trash', compact('users'));
    }
    
}
