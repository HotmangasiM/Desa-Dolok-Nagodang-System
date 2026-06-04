<?php

namespace App\Services;

use App\Interfaces\LetterRepositoryInterface;
use App\Models\Citizen;
use App\Models\Letter;
use App\Models\LetterType;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LetterService
{
    public function __construct(
        protected LetterRepositoryInterface $letterRepository
    ) {
    }

    public function getAll(array $filters = [], int $perPage = 10)
    {
        return $this->letterRepository->getAll($filters, $perPage);
    }

    public function getById(int $id)
    {
        return $this->letterRepository->getById($id);
    }

    public function create(array $data)
    {
        if (empty($data['submission_date'])) {
            $data['submission_date'] = now()->toDateString();
        }

        if (!empty($data['citizen_id'])) {
            $citizen = Citizen::find($data['citizen_id']);

            if(!$citizen) {
                throw ValidationException::withMessages([
                    'citizen_id' => 'Data warga tidak ditemukan.',
                ]);
            }

            $data['applicant_national_id'] = $citizen->nik;
        }

        if (empty($data['letter_number'])) {
            $data['letter_number'] = $this->generateLetterNumber(
                (int) $data['letter_type_id'],
                $data['submission_date']
            );
        }

        $statusMap = [
            'submitted' => 'SUBMITTED',
            'processed' => 'PROCESSING',
            'completed' => 'COMPLETED',
        ];

        $data['status'] = $statusMap[$data['status'] ?? 'submitted'] ?? 'SUBMITTED';

        //Hardcode sementar untuk field created_by oleh admin
        $data['created_by'] = auth()->id();

        $data['payload'] = $this->normalizePayload($data['payload'] ?? []);
        unset($data['citizen_id']);

        Log::debug('Data final sebelum insert letter', $data);

        return $this->letterRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        if (!empty($data['citizen_id'])) {
            $citizen = Citizen::find($data['citizen_id']);

            if (!$citizen) {
                throw ValidationException::withMessages([
                    'citizen_id' => 'Data warga tidak ditemukan.',
                ]);
            }

            $data['applicant_national_id'] = $citizen->nik;
        }

        $statusMap = [
            'submitted' => 'SUBMITTED',
            'processed' => 'PROCESSING',
            'completed' => 'COMPLETED',
        ];

        if (!empty($data['status'])) {
            $data['status'] = $statusMap[$data['status']] ?? $data['status'];
        }

        $data['payload'] = $this->normalizePayload($data['payload'] ?? []);

        unset($data['citizen_id']);

        return $this->letterRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->letterRepository->delete($id);
    }

    protected function generateLetterNumber(int $letterTypeId, string $submissionDate): string
    {
        $date = \Carbon\Carbon::parse($submissionDate);
        $month = (int) $date->format('m');
        $year = (int) $date->format('Y');

        $letterType = LetterType::findOrFail($letterTypeId);
        $code = strtoupper($letterType->code);

        $countThisMonth = Letter::query()
            ->where('letter_type_id', $letterTypeId)
            ->whereYear('submission_date', $year)
            ->whereMonth('submission_date', $month)
            ->count();

        $sequence = str_pad((string) ($countThisMonth + 1), 3, '0', STR_PAD_LEFT);
        $romanMonth = $this->toRomanMonth($month);

        return "{$sequence}/{$code}/{$romanMonth}/{$year}";
    }

    protected function normalizePayload(array $payload): array
    {
        foreach (['father_income', 'mother_income'] as $field) {
            if (!array_key_exists($field, $payload)) {
                continue;
            }

            $payload[$field] = $this->formatRupiah($payload[$field]);
        }

        return $payload;
    }

    protected function formatRupiah(?string $value): ?string
    {
        $digits = preg_replace('/\D/', '', (string) $value);

        if ($digits === '') {
            return null;
        }

        return 'Rp ' . number_format((int) $digits, 0, ',', '.');
    }

    protected function toRomanMonth(int $month): string
    {
        $romans = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII',
        ];
        return $romans[$month] ?? '-';
    }
}
