<?php

namespace App\Filament\Pages;

use App\Models\Card;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\EmbeddedTable;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ShareCards extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationLabel = 'Share Cards';

    protected static ?string $title = 'Share Cards';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShare;

    protected static ?int $navigationSort = 12;

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                EmbeddedTable::make(),
            ]);
    }

    protected function getTableQuery(): Builder
    {
        return Card::query()->with('user')->latest();
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('hiddenNum')
                    ->label('Card')
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('organization')
                    ->badge()
                    ->searchable(),
                TextColumn::make('state')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => match ((string) $state) {
                        '1' => 'Active',
                        '2' => 'Frozen',
                        '0' => 'Canceled',
                        '4' => 'Pending',
                        default => 'Unknown',
                    }),
                TextColumn::make('public_share_token')
                    ->label('Guest link')
                    ->formatStateUsing(function (?string $state): string {
                        if (blank($state)) {
                            return '—';
                        }

                        $url = URL::route('share_card', ['token' => $state], true);

                        return Str::limit($url, 36, '…');
                    })
                    ->copyable(fn (?string $state): bool => filled($state))
                    ->copyableState(fn (?string $state): ?string => filled($state)
                        ? URL::route('share_card', ['token' => $state], true)
                        : null)
                    ->url(fn (Card $record): ?string => filled($record->public_share_token)
                        ? route('share_card', ['token' => $record->public_share_token])
                        : null)
                    ->openUrlInNewTab()
                    ->copyMessage('Link copied to clipboard')
                    ->tooltip(function (?string $state): ?string {
                        if (blank($state)) {
                            return null;
                        }

                        return URL::route('share_card', ['token' => $state], true);
                    }),
            ])
            ->recordActions([
                Action::make('generateShareLink')
                    ->label('Share')
                    ->icon('heroicon-o-share')
                    ->color('primary')
                    ->visible(fn (Card $record): bool => blank($record->public_share_token))
                    ->action(function (Card $record): void {
                        $record->forceFill([
                            'public_share_token' => Card::newShareToken(),
                        ])->save();

                        Notification::make()
                            ->title('Share link created')
                            ->body('Guests can open the link in the “Guest link” column.')
                            ->success()
                            ->send();
                    }),
                Action::make('regenerateShareLink')
                    ->label('New link')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Regenerate share link?')
                    ->modalDescription('The old link will stop working immediately.')
                    ->visible(fn (Card $record): bool => filled($record->public_share_token))
                    ->action(function (Card $record): void {
                        $record->forceFill([
                            'public_share_token' => Card::newShareToken(),
                        ])->save();

                        Notification::make()
                            ->title('New share link generated')
                            ->success()
                            ->send();
                    }),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
