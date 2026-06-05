<?php

namespace App\Filament\Support;

use Illuminate\Database\Eloquent\Model;

class PreservesExistingUploads
{
    /**
     * Keep stored file paths when the upload field was left empty (not replaced).
     * Prevents one image upload from wiping another on the same form.
     *
     * @param  array<string>  $fileFields
     */
    public static function merge(array $data, Model $record, array $fileFields): array
    {
        foreach ($fileFields as $field) {
            $incoming = $data[$field] ?? null;
            $existing = $record->getAttribute($field);

            if (self::isEmptyUpload($incoming) && filled($existing)) {
                $data[$field] = $existing;
            }
        }

        return $data;
    }

    public static function isEmptyUpload(mixed $value): bool
    {
        if ($value === null || $value === '') {
            return true;
        }

        if (is_array($value)) {
            return $value === [] || empty(array_filter($value));
        }

        return false;
    }
}
