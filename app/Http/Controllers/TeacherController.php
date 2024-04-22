<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTeacherRequest;
use Illuminate\Validation\ValidationException;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::orderByDesc('id')->get();
        return view('admin.teachers.index', [
            'teachers' => $teachers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeacherRequest $request)
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'Data email not found'])->withInput();
        }

        if ($user->hasRole('teacher')) {
            return redirect()->back()->withErrors(['email' => 'Data email is registered as teacher'])->withInput();
        }

        DB::transaction(function () use ($user, $validated) {
            $validated['user_id']   = $user->id;
            $validated['is_active'] = true;

            unset($validated['email']);

            Teacher::create($validated);

            if ($user->hasRole('student')) {
                $user->removeRole('student');
            }
            $user->assignRole('teacher');
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        DB::beginTransaction();

        try {
            $teacher->delete();
            
            $user = User::findOrFail($teacher->user_id);
            $user->removeRole('teacher');
            $user->assignRole('student');

            DB::commit();

            return redirect()->route('admin.teachers.index')->with('success', 'Teacher deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();
            $error = ValidationException::withMessages([
                'system_error' => $e->getMessage()
            ]);
            throw $error;
        }
    }
}
