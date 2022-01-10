<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sixlive\TextCopy\TextCopy;

class ContactDetails extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ContactDetails::class;

    // public static $tableStyle = 'tight';

    public static $perPageOptions = [10, 20, 40];

    public static $group = 'CHRUCH';

    /**
     * The icon of the resource.
     *
     * @return string
     */
    public static function icon()
    {
        return view('nova::icons.icon-contact')->render();
    }

    /**
     * Custom query for searching 
     * */ 
    public static function indexQuery(NovaRequest $request, $query)
    {
        if($request->user()->role_id !== 1) {
        
            $query->select('contact_details.*', 'chu.name');
            $query->join('churches as chu', 'contact_details.church_id', '=', 'chu.id');
            $query->where('chu.user_id', '=', $request->user()->id);
    
            return $query;
            
        }
        
    }

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'value';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'value', 'ctype'
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

            BelongsTo::make('Church','church')
                ->searchable()
                ->readonly(function() {
                    return $this->resource->exists;
                }),

            Select::make('Type', 'ctype')
                ->options([
                    'Website' => 'Website',
                    'Email' => 'Email Address',
                    'Mobile' => 'Mobile Number',
                    'Office' => 'Office Number',
                    'Fax' => 'Fax Number'
                ])
                ->rules('required'),
            TextCopy::make('Contact Info', 'value')
                ->onlyOnIndex()
                ->hideWhenUpdating()
                ->hideWhenCreating(),

            Text::make('Contact Info', 'value')
                ->rules('required')
                ->hideFromIndex(),

            Textarea::make('Add Details', 'extra1')

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
