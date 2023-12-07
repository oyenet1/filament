<?php

use App\Models\Journey;
use App\Models\Configuration;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

function currentUser()
{
    return auth()->user();
}


function getCountries()
{
    $countries = Http::get('https://restcountries.com/v3.1/all?fields=name,idd,flags,currencies,capital');
    return $countries;
}

function redirectback()
{
    return redirect()->back();
}


function statusColor($status)
{
    // $color = "bg-gray-500 text-gray-50";
    switch ($status) {
        case 'active':
            $color = "border-green-500 text-green-500";
            break;
        case 'delivered':
            $color = "border-green-500 text-green-500";
            break;
        case 'created':
            $color = "border-green-300 text-green-300";
            break;
        case 'in-transit':
            $color = "border-blue-500 text-blue-500";
            break;
        case 'accepted':
            $color = "border-green-500 text-green-500";
            break;
        case 'onLeave':
            $color = "border-orange-400 text-orange-400";
            break;
        case 'credit':
            $color = "border-green-500 text-green-500";
            break;
        case 'debit':
            $color = "border-red-500 text-red-500";
            break;
        case 'expired':
            $color = "border-red-500 text-red-500";
            break;
        case 'expiring':
            $color = "border-yellow-500 text-yellow-500";
            break;
        case 'graduated':
            $color = "border-red-900 text-red-900";
            break;
        default:
            $color = "border-gray-500 text-gray-500 font-medium";
            break;
    }

    return $color;
}

function nigeriaState(): array
{
    return [
        "Abia",
        "Adamawa",
        "Akwa Ibom",
        "Anambra",
        "Bauchi",
        "Bayelsa",
        "Benue",
        "Borno",
        "Cross River",
        "Delta",
        "Ebonyi",
        "Edo",
        "Ekiti",
        "Enugu",
        "Gombe",
        "Imo",
        "Jigawa",
        "Kaduna",
        "Kano",
        "Katsina",
        "Kebbi",
        "Kogi",
        "Kwara",
        "Lagos",
        "Nasarawa",
        "Niger",
        "Ogun",
        "Ondo",
        "Osun",
        "Oyo",
        "Plateau",
        "Rivers",
        "Sokoto",
        "Taraba",
        "Yobe",
        "Zamfara",
        "Federal Capital Territory"
    ];
}

function userNameAbbr($pre): string
{
    if ($pre == "student") {
        return "STU";
    } else if ($pre == "admin") {
        return "ADM";
    } else if ($pre == "superadmin") {
        return "SUP";
    } else if ($pre == "teacher") {
        return "tchr";
    } else if ($pre == "class teacher") {
        return "CT";
    } else if ($pre == "human resources") {
        return "HR";
    } else if ($pre == "guardian") {
        return "GDN";
    } else if ($pre == "accountant") {
        return "ACCT";
    } else if ($pre == "librarian") {
        return "LIBN";
    } else if ($pre == "receptionist") {
        return "FD";
    } else {
        return "ST";
    }
}

function getUsersIdsByRole($val): array
{
    $ids = \App\Models\User::select('id')->where('current_role', $val)->pluck('id')->toArray();
    return $ids;
}

function isTimeToRenew($com)
{
    // $date1 = now()->format('Y-m-d');
    $date2 = date_create($com);
    $diff = date_diff(now(), $date2);
    return intval($diff->format("%R%a"));
}

function generateUniqueSchoolCode(string $input): string
{
    // Split the input into words
    $words = explode(' ', $input);

    // Initialize an empty abbreviation
    $abbreviation = '';

    // Take the first letter of each word and append to the abbreviation
    foreach ($words as $word) {
        $abbreviation .= strtoupper(substr($word, 0, 1));
    }

    // If the abbreviation is longer than three characters, truncate to three characters
    if (strlen($abbreviation) > 3) {
        $abbreviation = substr($abbreviation, 0, 3);
    }

    return $abbreviation;
}

function getCurrentTenant()
{
    return Filament::getTenant();
}

function formatNumber($number)
{
    if ($number >= 1000000) {
        // If the number is a million or more
        return $number / 1000000 . "M";
    } elseif ($number >= 1000) {
        // If the number is a thousand or more
        return $number / 1000 . "K";
    } else {
        // If the number is less than a thousand
        return $number;
    }
}

function annualActiveSchoolCount(): ?array
{
    return DB::table('schools')
        ->where('status', 'active')
        ->selectRaw('YEAR(created_at) as year, COUNT(*) as total')
        ->groupByRaw('YEAR(created_at)')->orderBy('year')
        ->pluck('total', 'year')->toArray();
}
function schoolChart(): ?array
{
    return DB::table('schools')->selectRaw('YEAR(created_at) as year, COUNT(*) as total')
        ->groupByRaw('YEAR(created_at)')->orderBy('year')
        ->pluck('total')->toArray();
}

function activeSchoolChart(): ?array
{
    return DB::table('schools')
        ->selectRaw('YEAR(created_at) as year, COUNT(*) as total')
        ->where('status', 'active')
        ->groupByRaw('YEAR(created_at)')
        ->orderBy('year')
        ->pluck('total')->toArray();
}

function getPercent($low, $high): ?string
{
    if ($low === 0) {
        return $high > 0 ? "100% increase" : "0% change";
    }

    $percent = round(($high - $low) / abs($low) * 100);
    $direction = ($high - $low) > 0 ? 'increase' : 'decrease';

    return abs($percent) . "% " . $direction;
}

function getDirectionIcon($low, $high): ?string
{
    return $high > $low ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down';
}


function generateHexColors($numColors)
{
    $colors = [];

    for ($i = 0; $i < $numColors; $i++) {
        $colors[] = '#' . substr(md5(rand()), 0, 6);
    }

    return $colors;
}

function generateColors($numColors)
{
    $rainbowColors = [
        '#00FF00',  // Green
        '#FFc500',  // Orange
        '#0000FF',  // Blue
        '#FF0000',  // Red
        '#4B0082',  // Indigo
        '#800080',  // Violet
        '#dd9F00',  // Yellow
    ];

    $colors = [];

    for ($i = 0; $i < $numColors; $i++) {
        $colors[] = $rainbowColors[$i % 7];
    }

    return $colors;
}
