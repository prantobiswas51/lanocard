<?php

namespace App\Filament\Resources\Notifications;

use App\Filament\Resources\Notifications\Pages\CreateNotification;
use App\Filament\Resources\Notifications\Pages\EditNotification;
use App\Filament\Resources\Notifications\Pages\ListNotifications;
use App\Filament\Resources\Notifications\Schemas\NotificationForm;
use App\Filament\Resources\Notifications\Tables\NotificationsTable;
use App\Models\Notification;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Http\Request;

class NotificationResource extends Resource
{
    protected static ?string $model = Notification::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'NotificationResource';

    public static function broadcast(Request $request): int
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $now = now();

        $notifications = User::pluck('id')->map(fn ($id) => [
            'user_id' => $id,
            'message' => $validated['message'],
            'is_read' => false,
            'created_at' => $now,
            'updated_at' => $now,
        ])->toArray();

        if (empty($notifications)) {
            return 0;
        }

        Notification::insert($notifications);

        return count($notifications);
    }

    public static function form(Schema $schema): Schema
    {
        return NotificationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NotificationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNotifications::route('/'),
            'create' => CreateNotification::route('/create'),
            'edit' => EditNotification::route('/{record}/edit'),
        ];
    }
}
