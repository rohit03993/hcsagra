<?php

namespace App\Filament\Concerns;

use App\Filament\Support\PreservesExistingUploads;

trait PreservesFileUploadsOnSave
{
    /**
     * @return array<int, string>
     */
    abstract protected function preservedUploadFields(): array;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $fields = $this->preservedUploadFields();

        if ($fields === []) {
            return $data;
        }

        return PreservesExistingUploads::merge($data, $this->getRecord(), $fields);
    }
}
