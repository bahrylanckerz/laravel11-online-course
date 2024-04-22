<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\CourseStudent;
use App\Models\SubscribeTransaction;
use App\Models\Teacher;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $categories   = Category::count();
        $courses      = Course::count();
        $students     = CourseStudent::count();
        $teachers     = Teacher::count();
        $transactions = SubscribeTransaction::count();
        
        return view('admin.dashboard', [
            'categories'   => $categories,
            'courses'      => $courses,
            'students'     => $students,
            'teachers'     => $teachers,
            'transactions' => $transactions,
        ]);
    }
}
