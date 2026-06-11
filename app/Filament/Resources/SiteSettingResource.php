<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages\EditSiteSetting;
use App\Filament\Resources\SiteSettingResource\Pages\ListSiteSettings;
use App\Filament\Support\ManagedImageUpload;
use App\Models\Page;
use App\Models\SiteSetting;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Site Settings';

    protected static ?int $navigationSort = 1;

    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Site settings')
                ->columnSpanFull()
                ->persistTabInQueryString()
                ->tabs([
                    Tab::make('General')
                        ->icon(Heroicon::OutlinedBuildingLibrary)
                        ->schema([
                            Section::make('School identity')
                                ->description('Name and branding used in the header, footer, and browser tab.')
                                ->schema([
                                    TextInput::make('school_name')->required()->maxLength(255),
                                    TextInput::make('tagline')->maxLength(255)
                                        ->helperText('Short line on homepage highlight cards.'),
                                    TextInput::make('affiliation_line')->placeholder('Affiliated to CBSE, New Delhi')->maxLength(255),
                                ])
                                ->columns(2),
                            Section::make('Brand images')
                                ->description('Upload logo and favicon separately — each keeps its own file when you save.')
                                ->schema([
                                    ...ManagedImageUpload::brandPair(),
                                ])
                                ->columns(1),
                        ]),
                    Tab::make('Homepage')
                        ->icon(Heroicon::OutlinedHome)
                        ->schema([
                            Textarea::make('about_text')->label('Who We Are')->rows(4)->columnSpanFull()
                                ->helperText('Main intro paragraph on the homepage.'),
                            Section::make('Mission & Vision')
                                ->description('Two cards on the homepage. One “Read more” page for both.')
                                ->schema([
                                    TextInput::make('mission_title')->default('Service Before Self'),
                                    Textarea::make('mission_text')->label('Mission text')->rows(3),
                                    TextInput::make('vision_title')->default('Our Vision'),
                                    Textarea::make('vision_text')->label('Vision text')->rows(3),
                                    Select::make('mission_vision_page_slug')
                                        ->label('Read more page')
                                        ->options(fn (): array => Page::query()
                                            ->where('is_published', true)
                                            ->orderBy('title')
                                            ->pluck('title', 'slug')
                                            ->all())
                                        ->searchable()
                                        ->nullable()
                                        ->native(false)
                                        ->columnSpanFull()
                                        ->helperText('Choose a page from CMS → Pages (e.g. Vision & Mission). Leave empty to hide “Read more” links.'),
                                ])
                                ->columns(2),
                            Section::make('Admission strip')
                                ->schema([
                                    Toggle::make('show_admission_banner')->label('Show yellow admission banner on site')->default(true),
                                    TextInput::make('admission_banner_text')->maxLength(255)->placeholder('Admission Open 2026–27'),
                                ])
                                ->columns(2),
                        ]),
                    Tab::make('SEO')
                        ->icon(Heroicon::OutlinedMagnifyingGlass)
                        ->schema([
                            Textarea::make('default_meta_description')
                                ->label('Homepage description for Google')
                                ->rows(3)
                                ->maxLength(160)
                                ->helperText('About 150 characters. Used when a page has no custom SEO description.'),
                            TextInput::make('google_analytics_measurement_id')
                                ->label('Google Analytics Measurement ID')
                                ->placeholder('G-XXXXXXXXXX')
                                ->maxLength(64)
                                ->helperText('Paste your GA4 ID from analytics.google.com → Admin → Data streams → Web → Measurement ID. Leave empty to turn off tracking. Only the public website is tracked — not the admin panel.'),
                        ]),
                    Tab::make('Contact')
                        ->icon(Heroicon::OutlinedPhone)
                        ->schema([
                            TextInput::make('phone')->tel()->maxLength(50),
                            TextInput::make('phone_secondary')->label('Second phone')->tel()->maxLength(50),
                            TextInput::make('email')->email()->maxLength(255),
                            Textarea::make('address')->rows(3)->columnSpanFull(),
                            Textarea::make('google_maps_embed_url')
                                ->label('Google Maps link (optional)')
                                ->rows(2)
                                ->columnSpanFull()
                                ->placeholder('https://maps.app.goo.gl/... or paste Embed map iframe HTML')
                                ->helperText('Paste the Share link (maps.app.goo.gl) or the full embed code from Google Maps → Share → Embed a map. If this fails, the map uses your address above.'),
                            TextInput::make('whatsapp_url')->label('WhatsApp link')->url()->maxLength(255)
                                ->placeholder('https://wa.me/91...')
                                ->columnSpanFull(),
                        ])
                        ->columns(2),
                    Tab::make('Links & social')
                        ->icon(Heroicon::OutlinedLink)
                        ->schema([
                            Section::make('Social media')
                                ->schema([
                                    TextInput::make('facebook_url')->url()->placeholder('https://facebook.com/...'),
                                    TextInput::make('instagram_url')->url()->placeholder('https://instagram.com/...'),
                                    TextInput::make('youtube_channel_url')->label('YouTube channel')->url()
                                        ->helperText('Footer YouTube icon links here.'),
                                ])
                                ->columns(2),
                            Section::make('Optional custom links')
                                ->description('Leave blank to use the built-in pages on your site — no need to paste the same URL twice.')
                                ->collapsed()
                                ->schema([
                                    TextInput::make('admission_url')
                                        ->label('Custom admission link')
                                        ->url()
                                        ->placeholder('Leave empty → uses /admission-enquiry form'),
                                    TextInput::make('mandatory_disclosure_url')
                                        ->label('Custom disclosure link')
                                        ->url()
                                        ->placeholder('Leave empty → uses /mandatory-disclosure'),
                                    TextInput::make('fee_payment_url')->label('Fee payment')->url(),
                                    TextInput::make('careers_url')->label('Careers')->url(),
                                ])
                                ->columns(2),
                        ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('school_name')->searchable(),
                TextColumn::make('phone'),
                TextColumn::make('email'),
            ])
            ->recordUrl(fn (SiteSetting $record): string => static::getUrl('edit', ['record' => $record]))
            ->recordActions([
                EditAction::make(),
            ])
            ->striped();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSiteSettings::route('/'),
            'edit' => EditSiteSetting::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return SiteSetting::query()->count() === 0;
    }
}
