<?php

namespace App\Filament\Support;

use App\Support\MediaUrl;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Large preview + upload box (crop with pencil, or X then replace).
 */
class ManagedImageUpload
{
    /** @var array<string, array{w: int, h: int, ratio: string, hint: string}> */
    public const PRESETS = [
        'hero' => [
            'w' => 1200,
            'h' => 675,
            'ratio' => '16:9',
            'hint' => 'Home banner',
        ],
        'gallery' => [
            'w' => 800,
            'h' => 800,
            'ratio' => '1:1',
            'hint' => 'Gallery square',
        ],
        'facility' => [
            'w' => 800,
            'h' => 500,
            'ratio' => '8:5',
            'hint' => 'Facility card',
        ],
        'post' => [
            'w' => 800,
            'h' => 500,
            'ratio' => '8:5',
            'hint' => 'News thumbnail',
        ],
        'desk' => [
            'w' => 400,
            'h' => 400,
            'ratio' => '1:1',
            'hint' => 'Principal / chairman photo',
        ],
        'page_hero' => [
            'w' => 1200,
            'h' => 600,
            'ratio' => '2:1',
            'hint' => 'Page header image',
        ],
        'logo' => [
            'w' => 400,
            'h' => 400,
            'ratio' => '1:1',
            'hint' => 'School logo',
        ],
        'favicon' => [
            'w' => 128,
            'h' => 128,
            'ratio' => '1:1',
            'hint' => 'Browser tab icon',
        ],
    ];

    /**
     * @return array<int, View|FileUpload>
     */
    public static function fields(
        string $field,
        string $preset,
        string $directory,
        bool $required = false,
        ?int $maxSizeKb = 5120,
        ?string $label = null,
    ): array {
        self::PRESETS[$preset] ?? throw new \InvalidArgumentException("Unknown image preset: {$preset}");

        $removeField = '_remove_'.$field;
        $replaceField = '_replace_'.$field;
        $presetConfig = self::PRESETS[$preset];

        return [
            Hidden::make($removeField)
                ->default(false)
                ->dehydrated()
                ->live(),
            Hidden::make($replaceField)
                ->default(false)
                ->dehydrated()
                ->live(),
            View::make('filament.forms.image-upload-helper')
                ->columnSpanFull()
                ->visible(fn (?Model $record): bool => $record !== null)
                ->viewData(fn (?Model $record): array => [
                    'path' => $record?->getAttribute($field),
                    'field' => $field,
                    'label' => $label ?? 'Image',
                    'ratio' => $presetConfig['ratio'],
                ]),
            self::make($field, $preset, $directory, $required, $maxSizeKb, $label, $removeField, $replaceField)
                ->columnSpanFull(),
        ];
    }

    public static function make(
        string $field,
        string $preset,
        string $directory,
        bool $required = false,
        ?int $maxSizeKb = 5120,
        ?string $label = null,
        ?string $removeField = null,
        ?string $replaceField = null,
    ): FileUpload {
        $removeField ??= '_remove_'.$field;
        $replaceField ??= '_replace_'.$field;
        $config = self::PRESETS[$preset] ?? throw new \InvalidArgumentException("Unknown image preset: {$preset}");

        Storage::disk('public')->makeDirectory($directory);

        $upload = FileUpload::make($field)
            ->label($label ?? 'Photo')
            ->image()
            ->disk('public')
            ->directory($directory)
            ->visibility('public')
            ->maxSize($maxSizeKb)
            ->acceptedFileTypes(self::acceptedTypesFor($preset))
            ->imagePreviewHeight(self::previewHeightFor($preset))
            ->imageAspectRatio($config['ratio'])
            ->itemPanelAspectRatio($config['ratio'])
            ->panelLayout('grid')
            ->automaticallyOpenImageEditorForAspectRatio()
            ->imageEditor()
            ->imageEditorEmptyFillColor('#f4f4f5')
            ->deletable(true)
            ->removeUploadedFileButtonPosition('right top')
            ->uploadButtonPosition('center')
            ->uploadProgressIndicatorPosition('center')
            ->imageEditorAspectRatioOptions([
                $config['ratio'] => $config['ratio'],
            ])
            ->imageEditorViewportWidth($config['w'])
            ->imageEditorViewportHeight($config['h'])
            ->openable()
            ->downloadable()
            ->previewable(true)
            ->reorderable(false)
            ->fetchFileInformation(true)
            ->extraAttributes(['class' => 'managed-image-upload'])
            ->getUploadedFileUsing(function (FileUpload $component, string $file, string | array | null $storedFileNames): ?array {
                $disk = Storage::disk('public');

                if (! $disk->exists($file)) {
                    return null;
                }

                $url = MediaUrl::public($file, versioned: true);

                if ($url === null) {
                    return null;
                }

                $name = is_array($storedFileNames)
                    ? ($storedFileNames[$file] ?? basename($file))
                    : ($storedFileNames ?? basename($file));

                $mime = $disk->mimeType($file) ?: self::mimeFromExtension($file);

                return [
                    'name' => $name,
                    'size' => $disk->size($file),
                    'type' => $mime,
                    'url' => $url,
                ];
            })
            ->helperText(
                "Ratio {$config['ratio']} (about {$config['w']}×{$config['h']} px). Click thumbnail → Edit to crop after upload."
            )
            ->visible(function (Get $get, ?Model $record) use ($field, $removeField, $replaceField): bool {
                if ($record === null) {
                    return true;
                }

                if (self::isTruthy($get($removeField))) {
                    return false;
                }

                $storedPath = $record->getAttribute($field);
                $hasStored = filled($storedPath) && Storage::disk('public')->exists($storedPath);

                if (! $hasStored) {
                    return true;
                }

                return self::isTruthy($get($replaceField));
            });

        if ($required) {
            $upload->required(function (Get $get, $livewire) use ($removeField): bool {
                if ($livewire instanceof CreateRecord) {
                    return true;
                }

                return ! self::isTruthy($get($removeField));
            });
        }

        return $upload;
    }

    private static function isTruthy(mixed $value): bool
    {
        return $value === true || $value === 1 || $value === '1' || $value === 'true';
    }

    private static function previewHeightFor(string $preset): string
    {
        return match ($preset) {
            'hero', 'page_hero' => '220',
            'favicon' => '140',
            default => '200',
        };
    }

    /**
     * @return array<int, string>
     */
    private static function acceptedTypesFor(string $preset): array
    {
        $types = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg', 'image/pjpeg'];

        if ($preset === 'logo') {
            $types[] = 'image/svg+xml';
        }

        return $types;
    }

    private static function mimeFromExtension(string $path): string
    {
        return match (strtolower(pathinfo($path, PATHINFO_EXTENSION))) {
            'png' => 'image/png',
            'webp' => 'image/webp',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'jfif', 'jpe' => 'image/jpeg',
            default => 'image/jpeg',
        };
    }

    /**
     * @return array<int, View|FileUpload>
     */
    public static function brandPair(
        string $logoField = 'logo_path',
        string $faviconField = 'favicon_path',
        string $directory = 'settings',
    ): array {
        return [
            ...self::fields($logoField, 'logo', $directory, maxSizeKb: 2048, label: 'School logo'),
            ...self::fields($faviconField, 'favicon', $directory, maxSizeKb: 1024, label: 'Favicon (browser tab)'),
        ];
    }
}
