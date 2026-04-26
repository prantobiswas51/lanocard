<?php

namespace App\Filament\Resources\Cards\Tables;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Mockery\Matcher\Not;

class CardsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('number')
                    ->searchable(),
                TextColumn::make('organization')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('state')
                    ->label('State')
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            '1' => 'Active',
                            '2' => 'Frozen',
                            '0' => 'Canceled',
                            '4' => 'Pending',
                            default => 'Unknown',
                        };
                    })
                    ->color(function ($state) {
                        return match ($state) {
                            '1' => 'success',
                            '2' => 'warning',
                            '0' => 'danger',
                            '4' => 'green',
                            default => 'gray',
                        };
                    })
                    ->searchable(),
                TextColumn::make('remark')
                    ->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('totalConsume')
                    ->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('totalRefund')
                    ->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('totalRecharge')
                    ->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('totalCashOut')
                    ->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                ViewAction::make(),
                Action::make('get_data')
                    ->label('Get Data')
                    ->icon('heroicon-o-arrow-path')
                    ->color('amber')
                    ->action(function ($record) {
                        // Call your controller logic here or use a service
                        app(\App\Http\Controllers\CardController::class)->get_data($record->id);

                        Notification::make()
                            ->title('Data fetched successfully!')
                            ->success()
                            ->send();
                    }),
                Action::make('send_mail')
                    ->label('Notify')
                    ->icon('heroicon-o-envelope')
                    ->color('primary')
                    ->action(function ($record) {

                        // Get card owner's email + card number
                        $email = $record->user->email;
                        $user_name = $record->user->name;
                        $card_number = $record->number;

                        // dd($user_name, $email, $card_number);

                        \App\Models\Notification::create([
                            'user_id' => $record->user_id,
                            'title' => 'New Virtual Card Created',
                            'message' => "Congratulations! Your new virtual card ($card_number) has been created successfully.",
                        ]);

                        // new mail template
                        $html = '
                                <div style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
                                    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); overflow: hidden;">
                                        
                                        <!-- Header -->
                                        <div style="background: linear-gradient(to right, #2563eb, #4f46e5); text-align: center; padding: 28px 20px;">
                                            <h1 style="margin: 0; font-size: 24px; font-weight: bold; color: #ffffff;">Lanocard</h1>
                                            <p style="margin: 6px 0 0; font-size: 13px; color: #bfdbfe;">Secure Virtual Card Service</p>
                                        </div>

                                        <!-- Body -->
                                        <div style="padding: 36px 32px;">
                                            <h2 style="margin: 0 0 12px; font-size: 20px; font-weight: 600; color: #1f2937;">Your Virtual Card is Ready 🎉</h2>
                                            <p style="margin: 0; font-size: 14px; color: #6b7280; line-height: 1.6;">
                                                Hello <strong style="color: #111827;">' . $user_name . '</strong>,
                                                your virtual card has been successfully created and is now ready to use for online transactions.
                                            </p>

                                            <!-- Card Info Box -->
                                            <div style="margin-top: 24px; border: 1px solid #e5e7eb; border-radius: 12px; background-color: #f9fafb; padding: 20px;">
                                                <p style="margin: 0 0 12px; font-size: 14px; font-weight: 600; color: #374151;">Card Information</p>
                                                <p style="margin: 0; font-size: 14px; color: #6b7280;">
                                                    Card Number:
                                                    <span style="color: #111827; font-weight: 700; letter-spacing: 0.1em;">' . $card_number . '</span>
                                                </p>
                                            </div>

                                            <!-- Security Notice -->
                                            <div style="margin-top: 20px; background-color: #fefce8; border: 1px solid #fde68a; border-radius: 8px; padding: 14px 16px;">
                                                <p style="margin: 0; font-size: 12px; color: #92400e; line-height: 1.5;">
                                                    ⚠️ For security reasons, never share your card details with anyone.
                                                    If you did not create this card, please contact our support team immediately.
                                                </p>
                                            </div>

                                            <!-- CTA Button -->
                                            <div style="text-align: center; margin-top: 32px;">
                                                <a href="https://lanocard.com/cards"
                                                style="display: inline-block; background-color: #2563eb; color: #ffffff; font-size: 14px;
                                                        font-weight: 600; padding: 12px 28px; border-radius: 8px; text-decoration: none;">
                                                    View Your Card
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Footer -->
                                        <div style="background-color: #f9fafb; border-top: 1px solid #e5e7eb; text-align: center; padding: 28px 24px;">
                                            <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #1f2937;">LanoCard</h3>
                                            <p style="margin: 4px 0 0; font-size: 13px; color: #9ca3af;">Safer Virtual Cards Worldwide</p>
                                            <div style="margin-top: 14px; font-size: 13px; color: #6b7280; line-height: 1.8;">
                                                <p style="margin: 0;">275 New North Road, Islington<br>N1 7AA, London, United Kingdom</p>
                                                <p style="margin: 4px 0 0;">✉️ <a href="mailto:hi@lanocard.com" style="color: #2563eb; text-decoration: none;">hi@lanocard.com</a></p>
                                                <p style="margin: 4px 0 0;">🌐 <a href="https://lanocard.com" style="color: #2563eb; text-decoration: none;">lanocard.com</a></p>
                                            </div>
                                            <div style="margin-top: 14px; font-size: 12px; color: #9ca3af;">
                                                <a href="https://lanocard.com/privacy" style="color: #9ca3af; text-decoration: none; margin-right: 8px;">Privacy Policy</a>
                                                <span>|</span>
                                                <a href="https://lanocard.com/terms" style="color: #9ca3af; text-decoration: none; margin-left: 8px;">Terms</a>
                                            </div>
                                            <p style="margin: 16px 0 0; font-size: 11px; color: #d1d5db;">© ' . date("Y") . ' Lanocard. All rights reserved.</p>
                                        </div>

                                    </div>
                                </div>
                        ';

                        
                            // Send email to card owner
                        sendCustomMail($email, 'New Virtual Card Created', $html);

                        Notification::make()
                            ->title('Email sent successfully!')
                            ->success()
                            ->send();
                    }),

                Action::make('freeze')
                    ->label('Freeze')
                    ->icon('heroicon-o-lock-closed')
                    ->color('amber')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $card = \App\Models\Card::findOrFail($record->id);
                        $timestamp = (string) round(microtime(true) * 1000);
                        $baseUrl = 'http://api.vcc.center';
                        $userSerial = '0852811946422621';
                        $secretKey = 'Okfc-yMDRgKig4E2V75pxw=='; // <-- set your secret key

                        // Inline sign function
                        $sign = function (array $params) use ($secretKey): string {
                            $filtered = array_filter($params, fn($value) => !is_null($value) && $value !== '');
                            ksort($filtered);
                            $query = urldecode(http_build_query($filtered));
                            $query = str_replace('+', '%20', $query);
                            $stringToSign = $query . '&key=' . $secretKey;

                            return strtoupper(md5($stringToSign));
                        };

                        $params = [
                            'userSerial' => $userSerial,
                            'timeStamp' => $timestamp,
                            'cardNum' => $card->number,
                        ];
                        $params['sign'] = $sign($params);

                        $response = \Illuminate\Support\Facades\Http::asForm()->put(
                            $baseUrl . '/bank_card/suspend',
                            $params
                        );

                        if ($response->failed()) {
                            \Filament\Notifications\Notification::make()
                                ->title('Card freeze request failed. Please try again.')
                                ->danger()
                                ->send();
                            return;
                        }

                        $card->state = '2';
                        $card->save();

                        \Filament\Notifications\Notification::make()
                            ->title('Card frozen successfully!')
                            ->success()
                            ->send();
                    }),


            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
