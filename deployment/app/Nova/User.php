<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\PasswordConfirmation;
use Laravel\Nova\Fields\Place;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class User extends Resource
{
    public static $group = 'Settings';
    
    /**
     * Hide navigation if not admin
     */
    public static function availableForNavigation(Request $request)
    {
        return $request->user()->role_id === 1 ? true : false;
    }
    
    public static function indexQuery(NovaRequest $request, $query)
    {
        if($request->user()->role_id !== 1)
            return $query->where('id', $request->user()->id);
    }

    /**
     * The icon of the resource.
     *
     * @return string
     */
    public static function icon()
    {
        return view('nova::icons.icon-user')->render();
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    // public static $title = 'email';

    /**
     * Overrding: Modify the display when searching/fetching
     *
     * @var array
     */
    public function title()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    /**
     * Get the search result subtitle for the resource.
     *
     * @return string
     */
    public function subtitle()
    {
        return "Email: " . $this->email;
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'firstname', 'lastname', 'email',
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
            Gravatar::make()->maxWidth(50),
            Text::make('First Name', 'firstname')->rules('required', 'max:255')->sortable(),
            Text::make('Last Name', 'lastname')->rules('required', 'max:255')->sortable(),
            Text::make('Email')->sortable()->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),
            Text::make('Phone Number', 'phoneNum'),

            BelongsTo::make('Role')->sortable(),

            (new Panel('Address', [
                Place::make('Address', 'address')->hideFromIndex(),
                Text::make('City')->hideFromIndex()->hideFromIndex(),
                Text::make('Postal Code', 'postal')->hideFromIndex(),
            ])),

            (new Panel('Password', [
                Password::make('Password')
                    ->onlyOnForms()
                    ->creationRules('required', 'string', 'min:8')
                    ->updateRules('nullable', 'string', 'min:8'),
                PasswordConfirmation::make(_('Password Confirmation'))
                    ->onlyOnForms()
                    ->rules('same:password')
                    ->creationRules('required', 'string', 'min:8')
                    ->updateRules('nullable', 'string', 'min:8', 'same:password')
            ])),

            HasMany::make('Church')->sortable()->hideFromDetail()->hideWhenCreating()->hideWhenUpdating(),
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
        return [
            
        ];
    }
}
