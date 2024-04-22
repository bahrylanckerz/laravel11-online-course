<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\CourseVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreSubscribeTransactionRequest;
use App\Models\SubscribeTransaction;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $courses    = Course::all();
        return view('home.index', [
            'categories' => $categories,
            'courses'    => $courses,
        ]);
    }

    public function details(Course $course)
    {
        return view('home.details', [
            'course' => $course,
        ]);
    }

    public function category(Category $category)
    {
        return view('home.category', [
            'category' => $category
        ]);
    }

    public function pricing()
    {
        return view('home.pricing');
    }

    public function checkout()
    {
        $user = Auth::user();

        if ($user->hasActiveSubscription()) {
            return redirect()->route('home.index');
        }

        return view('home.checkout');
    }

    public function checkoutStore(StoreSubscribeTransactionRequest $request)
    {
        $user = Auth::user();

        if ($user->hasActiveSubscription()) {
            return redirect()->route('home.index');
        }

        DB::transaction(function () use ($request, $user) {
            $validated = $request->validated();

            if ($request->hasFile('proof')) {
                $proofPath = $request->file('proof')->store('proofs', 'public');
            }

            $validated['total_amount'] = 429000;
            $validated['is_paid']      = false;
            $validated['user_id']      = $user->id;
            $validated['proof']        = $proofPath;

            SubscribeTransaction::create($validated);
        });

        return redirect()->route('dashboard')->with('success', 'Confirm payment successfully');
    }

    public function learning(Course $course, CourseVideo $courseVideo)
    {
        $user = Auth::user();

        if (!$user->hasActiveSubscription()) {
            return redirect()->route('home.pricing');
        }

        $user->courses()->syncWithoutDetaching($course->id);

        return view('home.learning', [
            'course'      => $course,
            'courseVideo' => $courseVideo,
        ]);
    }
}
