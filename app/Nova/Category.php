<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Category extends Resource
{
    public static $group = 'NON-PROFIT';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\OrgCategory::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';
    
    /**
     * Change the sidebar label
     */
    public static function label()
    {
        return 'Categories';
    }

    /**
     * The icon of the resource.
     *
     * @return string
     */
    public static function icon()
    {
        return view('nova::icons.icon-category')->render();
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
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
                ->rules('required')
                ->sortable(),
            
            Text::make('Slug', 'slug')
                ->showOnDetail()
                ->showOnIndex()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Slug::make('Slug', 'slug')
                ->from('name')
                ->rules('required')
                ->placeholder('Auto-generated URL based on name')
                ->separator('-')
                ->creationRules('unique:org_categories,slug')
                ->updateRules('unique:org_categories,slug,{{resourceId}}')
                ->hideFromIndex()
                ->hideFromDetail(),

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
