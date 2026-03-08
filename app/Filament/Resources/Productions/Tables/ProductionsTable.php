<?php

namespace App\Filament\Resources\Productions\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;

class ProductionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('project.project_number')
                ->label('Project Number')
                ->searchable()
                ->sortable(),
                TextColumn::make('project.project_type')
                ->label('Project Name')
                ->searchable()
                ->sortable(),
                TextColumn::make('project.client.name')
                ->label('Client Name')
                ->searchable()
                ->sortable(),
                TextColumn::make('status')
                ->label('Status')
                ->searchable()
                ->sortable(),
                TextColumn::make('progress')
                ->label('Progress')
                ->formatStateUsing(fn($state) => $state . '%')
                ->searchable()
                ->sortable(),
                TextColumn::make('start_date')
                ->label('Start Date')
                ->date()
                ->searchable()
                ->sortable(),
                TextColumn::make('end_date')
                ->label('End Date')
                ->date()
                ->searchable()
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make()
                        ->modal()
                        ->modalHeading('Edit Production')
                        ->modalSubmitActionLabel('Save'),
                    Action::make('create_purchase_order')
                        ->label('Create Purchase Order')
                        ->icon('heroicon-o-shopping-cart')
                        ->url(fn ($record) => \App\Filament\Resources\PurchaseOrders\PurchaseOrderResource::getUrl('create', ['production_id' => $record->id])),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
