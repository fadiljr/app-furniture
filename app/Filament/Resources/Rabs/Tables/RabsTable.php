<?php

namespace App\Filament\Resources\Rabs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use iluminate\Database\Eloquent\Builder;

class RabsTable
{
    public static function configure(Table $table): Table
    {
        return $table
             ->columns([

                TextColumn::make('nomor_rab')
                    ->label('RAB Number')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('project.project_type')
                    ->label('Project Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tanggal')
                    ->label('Date')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('expired_date')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('grand_total')
                    ->money('IDR')
                    ->sortable(),

                BadgeColumn::make('status')
                    ->colors([
                        'gray' => 'Draft',
                        'warning' => 'Dikirim',
                        'success' => 'Disetujui',
                        'danger' => 'Ditolak',
                    ]),
            ])

            ->filters([

                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'dikirim' => 'Dikirim',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                    ]),

            ])

            ->actions([

                EditAction::make(),

                Action::make('approve')
                    ->label('Approve')
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->visible(fn ($record) => $record->status === 'draft')
                    ->action(fn ($record) => $record->update([
                        'status' => 'disetujui'
                    ])),

                Action::make('kirim')
                    ->label('Kirim')
                    ->color('warning')
                    ->icon('heroicon-o-paper-airplane')
                    ->visible(fn ($record) => $record->status === 'draft')
                    ->action(fn ($record) => $record->update([
                        'status' => 'dikirim'
                    ])),

                DeleteAction::make()
                    ->visible(fn ($record) => $record->status === 'draft'),
            ])

            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
