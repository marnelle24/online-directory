<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Place;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Organization extends Resource
{

    public static $tableStyle = 'tight';

    public static $showColumnBorders = true;

    public static $perPageOptions = [10, 20, 30];

    public static $group = 'NON-PROFIT';

    /**
     * Change the sidebar label
     */
    public static function label()
    {
        return 'Organisations';
    }

    /**
     * The icon of the resource.
     *
     * @return string
     */
    public static function icon()
    {
        return view('nova::icons.icon-organisation')->render();
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Organization::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name', 'type'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            // ID::make(__('ID'), 'id')->sortable(),

            Text::make('Name', 'name')
                ->sortable()
                ->rules('required')
                ->creationRules('unique:organizations,name')
                ->updateRules('unique:organizations,name,{{resourceId}}'),

            Slug::make('slug')->from('name')
                ->separator('-')
                ->hideFromIndex()
                ->hideFromDetail()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Text::make('Chinese Name', 'name_chi'),

            Text::make('Type')->sortable()
                ->rules('required'),
            
            Select::make('Type', 'type')
                ->options([
                    'church' => 'Church',
                    'organisation' => 'Organisation'
                ])
                ->displayUsingLabels()
                ->hideFromIndex(),

            Text::make('CH Registration Code', 'chreg')
                ->rules('required')
                ->hideFromIndex(),
            
            DateTime::make('Date Founded', 'date_founded')
                ->hideFromIndex(),
            
            Boolean::make('Is NCCS Member', 'is_nccsmember')
                ->rules('required')
                ->hideFromIndex(),
            
            new Panel('Address Information', $this->addressFields()),

            new Panel('Mailing Address Information', $this->mailingAddressFields()),
            
            Trix::make('Mission', 'mission')
                ->hideFromIndex(),

            Trix::make('Mission (Chinese)', 'mission_chi')
                ->hideFromIndex(),
            
            Trix::make('Vision', 'vision')
                ->hideFromIndex(),
            
            Trix::make('Vision (Chinese)', 'vision_chi')
                ->hideFromIndex(),


        ];
    }

    /**
     * ADDRESS FIELDS
     * Get the address fields for the resource.
     * @return \Illuminate\Http\Resources\MergeValue
     */
    protected function addressFields()
    {
        return [
            Text::make('Building Name', 'bldg_name')->hideFromIndex(),
            Place::make('Address', 'address')->hideFromIndex(),
            Text::make('City')->hideFromIndex(),
            Text::make('Postal Code', 'postcode')->hideFromIndex(),
        ];
    }

    /**
     * MAILING ADDRESS
     * Get the address fields for the resource.
     */
    protected function mailingAddressFields()
    {
        return [
            Text::make('Building Name', 'mbldg_name')->hideFromIndex(),
            Place::make('Address', 'maddress')->hideFromIndex(),
            Text::make('City', 'mcity')->hideFromIndex(),
            Text::make('Postal Code', 'mpostcode')->hideFromIndex(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
