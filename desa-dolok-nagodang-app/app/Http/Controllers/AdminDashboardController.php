<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Citizen;
use App\Models\Letter;
use App\Models\News;
use App\Models\Official;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $totalCitizens = Citizen::count();
        $maleCitizens = Citizen::where('gender', 'Laki-laki')->count();
        $femaleCitizens = Citizen::where('gender', 'Perempuan')->count();

        $totalOfficials = Official::count();

        $totalNews = News::count();
        $publishedNews = News::where('status', 'published')->count();

        $totalAssets = Asset::count();
        $goodAssets = Asset::where('condition', 'good')->count();

        $totalLetters = Letter::count();
        $submittedLetters = Letter::where('status', 'SUBMITTED')->count();
        $processedLetters = Letter::where('status', 'PROCESSING')->count();
        $completedLetters = Letter::where('status', 'COMPLETED')->count();

        $recentLetters = Letter::with(['letterType', 'citizen'])
            ->latest('submission_date')
            ->latest('id')
            ->take(5)
            ->get();

        $lettersByMonth = Letter::selectRaw('MONTH(submission_date) as month, COUNT(*) as total')
            ->whereNotNull('submission_date')
            ->groupBy(DB::raw('MONTH(submission_date)'))
            ->orderBy(DB::raw('MONTH(submission_date)'))
            ->get();

        $monthNames = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Agu',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des',
        ];

        $monthlyLabels = [];
        $monthlyData = [];

        foreach ($lettersByMonth as $item) {
            $monthlyLabels[] = $monthNames[(int) $item->month] ?? (string) $item->month;
            $monthlyData[] = (int) $item->total;
        }

        return view('admin.dashboard.index', [
            'title' => 'Admin Desa - Dashboard',
            'pageTitle' => 'Dashboard Admin',
            'pageDescription' => 'Ringkasan data dan aktivitas utama sistem informasi desa.',
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => null],
            ],

            // Variabel utama
            'totalCitizens' => $totalCitizens,
            'maleCitizens' => $maleCitizens,
            'femaleCitizens' => $femaleCitizens,

            'totalOfficials' => $totalOfficials,

            'totalNews' => $totalNews,
            'publishedNews' => $publishedNews,

            'totalAssets' => $totalAssets,
            'goodAssets' => $goodAssets,

            'totalLetters' => $totalLetters,
            'submittedLetters' => $submittedLetters,
            'processedLetters' => $processedLetters,
            'completedLetters' => $completedLetters,

            'recentLetters' => $recentLetters,
            'monthlyLabels' => $monthlyLabels,
            'monthlyData' => $monthlyData,

            // Alias untuk kompatibilitas Blade lama
            'allCitizens' => $totalCitizens,
            'allOfficials' => $totalOfficials,
            'allNews' => $totalNews,
            'allAssets' => $totalAssets,
            'allLetters' => $totalLetters,
            'approvedLetters' => $completedLetters,
        ]);
    }
}