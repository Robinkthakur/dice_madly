<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('User Profile Management')
                    ->columnSpanFull()
                    ->tabs([
                        Tabs\Tab::make('Account & Status')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        Section::make('Credentials')
                                            ->columnSpan(2)
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema([
                                                        TextInput::make('profile_id')
                                                            ->disabled()
                                                            ->dehydrated(false)
                                                            ->placeholder('Automatically generated'),
                                                        TextInput::make('email')
                                                            ->email()
                                                            ->required()
                                                            ->unique(ignoreRecord: true),
                                                        TextInput::make('first_name')
                                                            ->required(),
                                                        TextInput::make('last_name')
                                                            ->required(),
                                                        TextInput::make('phone')
                                                            ->tel()
                                                            ->required()
                                                            ->unique(ignoreRecord: true),
                                                        TextInput::make('onboarding_step')
                                                            ->required()
                                                            ->default('bio_dp'),
                                                    ]),
                                            ]),
                                        
                                        Section::make('System Flags')
                                            ->columnSpan(1)
                                            ->schema([
                                                Toggle::make('is_active')
                                                    ->label('Account Active')
                                                    ->default(true),
                                                Toggle::make('is_verified')
                                                    ->label('Verified Account')
                                                    ->default(false),
                                                Toggle::make('is_admin')
                                                    ->label('Administrator')
                                                    ->default(false),
                                                DatePicker::make('verified_until')
                                                    ->label('Verified Until')
                                                    ->nullable(),
                                                FileUpload::make('profile_image')
                                                    ->image()
                                                    ->disk('public')
                                                    ->directory('profiles')
                                                    ->imageEditor(),
                                            ]),
                                    ]),
                            ]),

                        Tabs\Tab::make('Personal & Profile')
                            ->icon('heroicon-o-identification')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        Section::make('Demographics')
                                            ->columnSpan(1)
                                            ->schema([
                                                Select::make('gender')
                                                    ->options([
                                                        'Male' => 'Male',
                                                        'Female' => 'Female',
                                                    ])
                                                    ->required(),
                                                TextInput::make('age')
                                                    ->numeric()
                                                    ->minValue(18),
                                                Select::make('marital_status')
                                                    ->options([
                                                        'Never Married' => 'Never Married',
                                                        'Divorced' => 'Divorced',
                                                        'Widowed' => 'Widowed',
                                                        'Awaiting Divorce' => 'Awaiting Divorce',
                                                    ]),
                                                DatePicker::make('dob')
                                                    ->label('Date of Birth'),
                                            ]),

                                        Section::make('Preferences & Lifestyle')
                                            ->columnSpan(2)
                                            ->relationship('profile')
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema([
                                                        TextInput::make('about_me')
                                                            ->columnSpan(2),
                                                        TextInput::make('height'),
                                                        TextInput::make('weight'),
                                                        TextInput::make('religion'),
                                                        TextInput::make('caste'),
                                                        TextInput::make('sub_caste'),
                                                        TextInput::make('mother_tongue'),
                                                        TextInput::make('country'),
                                                        TextInput::make('state'),
                                                        TextInput::make('city'),
                                                        TextInput::make('citizenship'),
                                                        TextInput::make('diet'),
                                                        Select::make('smoking')
                                                            ->options([
                                                                'Yes' => 'Yes',
                                                                'No' => 'No',
                                                            ]),
                                                        Select::make('drinking')
                                                            ->options([
                                                                'Yes' => 'Yes',
                                                                'No' => 'No',
                                                            ]),
                                                    ]),
                                            ]),
                                    ]),
                            ]),

                        Tabs\Tab::make('Education & Career')
                            ->icon('heroicon-o-academic-cap')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Section::make('Education')
                                            ->relationship('education')
                                            ->schema([
                                                TextInput::make('highest_qualification')
                                                    ->label('Highest Qualification'),
                                                TextInput::make('college'),
                                                TextInput::make('university'),
                                            ]),

                                        Section::make('Occupation')
                                            ->relationship('occupation')
                                            ->schema([
                                                TextInput::make('occupation')
                                                    ->label('Occupation / Job Title'),
                                                TextInput::make('company'),
                                                TextInput::make('annual_income')
                                                    ->label('Annual Income'),
                                            ]),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
