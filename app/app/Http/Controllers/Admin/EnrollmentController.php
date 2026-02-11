<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Services\CertificateService;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with(['user', 'course'])->latest()->get();

        return view('admin.enrollments.index', compact('enrollments'));
    }

    public function generate(Request $request, Enrollment $enrollment, CertificateService $service)
    {
        if ($enrollment->certificate_number) {
            return back()->withErrors(['certificate' => 'Certificate already generated.']);
        }

        $number = $service->generate($enrollment);
        $enrollment->certificate_number = $number;
        $enrollment->certificate_generated_at = now();
        $enrollment->save();

        return redirect()->route('admin.enrollments.index');
    }
}
