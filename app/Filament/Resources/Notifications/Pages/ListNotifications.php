<?php

namespace App\Filament\Resources\Notifications\Pages;

use App\Filament\Resources\Notifications\NotificationResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Http\Request;

class ListNotifications extends ListRecords
{
    protected static string $resource = NotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('broadcast')
                ->label('Broadcast Notification')
                ->icon('heroicon-o-megaphone')
                ->color('primary')
                ->form([
                    Textarea::make('message')
                        ->label('Message')
                        ->required()
                        ->maxLength(1000)
                        ->rows(5),
                ])
                ->action(function (array $data): void {
                    $request = Request::create('/', 'POST', [
                        'message' => $data['message'],
                    ]);

                    $sentCount = NotificationResource::broadcast($request);

                    Notification::make()
                        ->title('Notification broadcast complete')
                        ->body("Sent to {$sentCount} users.")
                        ->success()
                        ->send();
                }),
            CreateAction::make(),
        ];
    }
}
