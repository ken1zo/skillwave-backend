<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MockCertificateController extends Controller
{
    public function getSeries(Request $request)
    {
        $data = $request->validate([
            'enrollment_id' => ['required', 'integer'],
        ]);

        $series = 'SW';
        $checksum = substr(hash('sha256', $data['enrollment_id'].'|'.config('app.key')), 0, 8);

        return response()->json([
            'series' => $series,
            'checksum' => $checksum,
        ]);
    }
}
