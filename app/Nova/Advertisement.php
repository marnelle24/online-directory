<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Advertisement extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Advert::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title', 'description', 'ads_type'
    ];

    /**
     * Change the sidebar label
     */
    public static function label()
    {
        return 'Advert';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Image::make('Upload Banner', 'banner')
                ->disk('public')
                ->path('adverts')
                ->storeAs(function (Request $request) {
                    return round(microtime(true)) . '.' .  $request->banner->getClientOriginalExtension();
                })
                ->help('This is the image to show in the homepage area. Make sure it is high resolution')
                ->deletable(false)
                ->hideFromIndex()
                ->prunable()
                ->rules('required'),

            Text::make('Title', 'title')
                ->sortable()
                ->rules('required'),
            
            Textarea::make('Description', 'description'),

            Select::make('Type', 'ads_type')
                ->options([
                    'Full-width Slider' => 'Full-width Slider',
                    'Vertical Sidebar' => 'Vertical Sidebar',
                    'Horizontal Banner' => 'Horizontal Banner',
                ])
                ->rules('required'),
            
            Number::make('Priority', 'order')
                ->default(0),
            
            Date::make('Start Date', 'start_date')
                ->rules('required'),
            
            Date::make('Valid Until', 'valid_until')
                    

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
