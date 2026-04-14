<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Citizen;
use App\Models\Official;
use App\Models\News;
use App\Models\Asset;
use App\Models\Letter;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        // Chart Surat per bulan
        $lettersPerMonth = Letter::select(
            DB::raw('MONTH(submission_date) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

        // format ke 12 bulan
        $monthlyLabels = [];
        $monthlyData = [];

        for ($i = 1; $i <= 12; $i++) {
            $monthlyLabels[] = date('M', mktime(0, 0, 0, $i, 1));
            $monthlyData[] = $lettersPerMonth[$i] ?? 0;
        }

        // Gender chart
        $genderData = [
            'L' => Citizen::where('gender', 'L')->count(),
            'P' => Citizen::where('gender', 'P')->count(),
        ];
        return view('admin.dashboard.index', [
            'title' => 'Admin Desa - Dashboard',
            'pageTitle' => 'Dashboard Admin',
            'pageDescription' => 'Ringkasan data dan aktivitas sistem informasi desa.',

            'totalCitizens' => Citizen::count(),
            'maleCitizens' => Citizen::where('gender', 'L')->count(),
            'femaleCitizens' => Citizen::where('gender', 'P')->count(),

            'totalOfficials' => Official::count(),

            'totalNews' => News::count(),
            'publishedNews' => News::where('status', 'published')->count(),

            'totalAssets' => Asset::count(),
            'goodAssets' => Asset::where('condition', 'good')->count(),

            'totalLetters' => Letter::count(),
            'submittedLetters' => Letter::where('status', 'submitted')->count(),
            'approvedLetters' => Letter::where('status', 'approved')->count(),

            'recentLetters' => Letter::with(['citizen', 'letterType'])
                ->latest()
                ->limit(5)
                ->get(),
            'monthlyLabels' => $monthlyLabels,
            'monthlyData' => $monthlyData,
            'genderData' => $genderData,
        ]);
    }
}