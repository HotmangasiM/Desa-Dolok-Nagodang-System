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
        // =============================
        // 📊 CITIZENS
        // =============================
        $totalCitizens = Citizen::count();
        $maleCitizens = Citizen::where('gender', 'Laki-laki')->count();
        $femaleCitizens = Citizen::where('gender', 'Perempuan')->count();

        // =============================
        // 👨‍💼 OFFICIALS
        // =============================
        $totalOfficials = Official::count();

        // =============================
        // 📰 NEWS
        // =============================
        $totalNews = News::count();
        $publishedNews = News::where('status', 'published')->count();

        // =============================
        // 📦 ASSETS
        // =============================
        $totalAssets = Asset::count();
        $goodAssets = Asset::where('condition', 'good')->count();

        // =============================
        // 📄 LETTERS
        // =============================
        $totalLetters = Letter::count();
        $submittedLetters = Letter::where('status', 'SUBMITTED')->count();
        $processedLetters = Letter::where('status', 'PROCESSING')->count();
        $completedLetters = Letter::where('status', 'COMPLETED')->count();

        $recentLetters = Letter::with(['letterType', 'citizen'])
            ->latest('submission_date')
            ->latest('id')
            ->take(5)
            ->get();

        // =============================
        // 📊 LETTER PER MONTH
        // =============================
        $currentYear = now()->year;

        $lettersByMonth = Letter::selectRaw('MONTH(submission_date) as month, COUNT(*) as total')
            ->whereYear('submission_date', $currentYear)
            ->whereNotNull('submission_date')
            ->groupBy(DB::raw('MONTH(submission_date)'))
            ->orderBy(DB::raw('MONTH(submission_date)'))
            ->pluck('total', 'month');

        $monthlyLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $monthlyData = [];

        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[] = (int) ($lettersByMonth[$i] ?? 0);
        }

        // =============================
        // 🔥 DUSUN STATS (DARI ADDRESS)
        // =============================
        $dusunStats = DB::table(function ($query) {
            $query->selectRaw("SUBSTRING_INDEX(address, ' ', 2) as dusun")
                  ->from('citizens');
        }, 't')
        ->select('dusun', DB::raw('COUNT(*) as total'))
        ->groupBy('dusun')
        ->orderBy('dusun')
        ->get();

        // format untuk chart
        $dusunLabels = $dusunStats->pluck('dusun');
        $dusunData = $dusunStats->pluck('total');

        return view('admin.dashboard.index', [
            'title' => 'Admin Desa - Dashboard',
            'pageTitle' => 'Dashboard',
            'pageDescription' => 'Ringkasan data sistem informasi desa.',
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => null],
            ],

            // citizens
            'totalCitizens' => $totalCitizens,
            'maleCitizens' => $maleCitizens,
            'femaleCitizens' => $femaleCitizens,

            // officials
            'totalOfficials' => $totalOfficials,

            // news
            'totalNews' => $totalNews,
            'publishedNews' => $publishedNews,

            // assets
            'totalAssets' => $totalAssets,
            'goodAssets' => $goodAssets,

            // letters
            'totalLetters' => $totalLetters,
            'submittedLetters' => $submittedLetters,
            'processedLetters' => $processedLetters,
            'completedLetters' => $completedLetters,

            'recentLetters' => $recentLetters,
            'monthlyLabels' => $monthlyLabels,
            'monthlyData' => $monthlyData,

            // 🔥 NEW (dusun)
            'dusunLabels' => $dusunLabels,
            'dusunData' => $dusunData,
            'dusunStats' => $dusunStats,

            // alias kompatibilitas
            'allCitizens' => $totalCitizens,
            'allOfficials' => $totalOfficials,
            'allNews' => $totalNews,
            'allAssets' => $totalAssets,
            'allLetters' => $totalLetters,
            'approvedLetters' => $completedLetters,
        ]);
    }
}