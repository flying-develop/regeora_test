<?php

namespace App\Http\Helpers;

use App\Jobs\PatienJob;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class PatientHelper
{

    public static function add($data): array
    {

        $now = Carbon::now();
        $birth = Carbon::parse($data['birthdate']);

        $age = $now->diffInDays($birth);
        $age_type = 'день';

        if ($years = $now->diffInYears($birth)) {
            $age = $years;
            $age_type = 'год';
        } else if ($months = $now->diffInMonths($birth)) {
            $age = $months;
            $age_type = 'месяц';
        }

        $patient = Patient::query()->create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'birthdate' => $birth,
            'age' => $age,
            'age_type' => $age_type
        ]);

        self::patients();

        PatienJob::dispatch($patient);

        return $patient->toArray();
    }

    public static function patients()
    {
        return Cache::remember('patients', now()->addMinutes(5), function () {
            return Patient::query()->list()->get();
        });
    }

}
