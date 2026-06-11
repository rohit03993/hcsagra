<?php

namespace App\Filament\Concerns;

use App\Support\UploadCleanup;

trait PreservesFileUploadsOnSave
{
    /** @var array<string, string|null> */
    protected array $uploadPathsBeforeSave = [];

    /**
     * @return array<int, string>
     */
    abstract protected function preservedUploadFields(): array;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $fields = $this->preservedUploadFields();

        foreach ($fields as $field) {
            $this->uploadPathsBeforeSave[$field] = $this->getRecord()->getAttribute($field);
            $removeKey = '_remove_'.$field;

            if ($this->isTruthy($data[$removeKey] ?? null)) {
                UploadCleanup::deleteIfStored($this->uploadPathsBeforeSave[$field]);
                $data[$field] = null;
            }

            unset($data[$removeKey]);
            unset($data['_replace_'.$field]);
        }

        return $data;
    }

    protected function afterSave(): void
    {
        $record = $this->getRecord();

        foreach ($this->preservedUploadFields() as $field) {
            $old = $this->uploadPathsBeforeSave[$field] ?? null;
            $new = $record->getAttribute($field);

            if (filled($old) && $old !== $new) {
                UploadCleanup::deleteIfStored($old);
            }
        }
    }

    private function isTruthy(mixed $value): bool
    {
        return $value === true || $value === 1 || $value === '1' || $value === 'true';
    }
}
