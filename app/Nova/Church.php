<?php

namespace App\Nova;

use App\Nova\Actions\AddServiceSchedule;
use App\Nova\Actions\AssignDenomination;
use App\Nova\Actions\AssignUser;
use App\Nova\Actions\UpdateStatuses;
use App\Nova\Filters\Approved;
use App\Nova\Filters\Denomination;
use App\Nova\Filters\Published;
use App\Nova\Filters\Searchable;
use App\Nova\Metrics\NewChurches;
use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Laravel\Nova\Fields\Slug;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Place;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Sixlive\TextCopy\TextCopy;

class Church extends Resource
{

    // public static $showColumnBorders = true;
    
    // public static $tableStyle = 'tight';

    public static $perPageOptions = [10, 20, 40, 50, 100, 200, 300, 500];

    public static $group = 'CHRUCH';

    /**
     * Change the sidebar label
     */
    public static function label()
    {
        return 'Churches';
    }

    /**
     * The icon of the resource.
     *
     * @return string
     */
    public static function icon()
    {
        return view('nova::icons.icon-church')->render();
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Church::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * Custom query for searching 
     * */ 
    public static function indexQuery(NovaRequest $request, $query)
    {   
        if($request->user()->role_id !== 1) {

            // $query->join('church_user', 'church_user.church_id', '=', 'churches.id');
            $query->where('user_id', '=', $request->user()->id);
            return $query;
        }
    }


    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name', 'denomination'
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

            Avatar::make('', 'avatar')
                ->disk('public')
                ->path('avatar')
                ->onlyOnIndex(),
            
            TextCopy::make('Name', 'name')
                ->sortable()
                ->showButtonOnlyOnHover()
                ->onlyOnIndex()
                ->showOnDetail(),

            Text::make('Name', 'name')
                ->onlyOnForms()
                ->rules('required')
                ->creationRules('unique:churches,name')
                ->updateRules('unique:churches,name,{{resourceId}}'),

            Slug::make('Slug', 'slug')
                ->from('name')
                ->rules('required')
                ->placeholder('Auto-generated URL based on name')
                ->separator('-')
                ->creationRules('unique:churches,slug')
                ->updateRules('unique:churches,slug,{{resourceId}}')
                ->hideFromIndex()
                ->hideFromDetail(),

            Text::make('Chinese Name', 'name_chi')
                ->placeholder('Chinese Name (if any)')
                ->hideFromIndex(),

            Text::make('CH Registration', 'chreg')
                ->placeholder('CH Registration Code')
                ->rules('required')
                ->hideFromIndex(),
            
            
            Boolean::make('Is NCCS Member', 'is_nccsmember')
                ->hideFromIndex(),

            BelongsTo::make('Denomination', 'denomination')
                ->sortable()
                ->hideWhenCreating()
                ->readonly(),

            Select::make('Denomination', 'denomination_id')
                ->searchable()
                ->options(function() {
                    return array_filter(\App\Models\Denomination::where('status', true)->pluck('name', 'id')->toArray());
                })
                ->hideFromIndex()
                ->hideFromDetail()
                ->hideWhenUpdating()
                ->rules('required'),
            
            // Boolean::make('Approved', 'is_approved')
            //     ->onlyOnIndex(),
            
            Text::make('', function() {

                if($this->is_approved === 1)
                    return '<span class="inline-flex items-center justify-center px-2 py-1 text-sm mr-3 ml-3 opacity-75 leading-none text-white bg-success rounded-full">Approved</span>';
                else
                    return '<span class="inline-flex items-center justify-center px-2 py-1 text-sm mr-3 ml-3 opacity-75 leading-none text-white bg-danger rounded-full">Pending</span>';
                    
            })->asHtml()
            ->onlyOnIndex(),

            Boolean::make('Published', 'is_published')
                ->onlyOnIndex(),

            Boolean::make('Searchable', 'is_searchable')
                ->onlyOnIndex(),
            
            Heading::make('Profile Avatar')
                ->onlyOnIndex(),

            Image::make('Upload Avatar', 'avatar')
                ->disk('public')
                ->path('avatar')
                ->storeAs(function (Request $request) {
                    return round(microtime(true)) . '.' .  $request->avatar->getClientOriginalExtension();
                })
                // ->rules('size:max:3072')
                ->maxWidth(100)
                ->help('Upload an image to display as profile photo. Max size: 3MB')
                ->deletable(false)
                ->onlyOnForms()
                ->prunable(),
 
            Heading::make('Primary Address')->hideFromDetail(),
            Text::make('Building Name', 'bldg_name')->hideFromIndex()->hideFromDetail(),
            Place::make('Address', 'address')->hideFromIndex()->hideFromDetail(),
            Text::make('City')->hideFromIndex()->hideFromDetail(),
            Text::make('Postal Code', 'postcode')->hideFromIndex()->hideFromDetail(),

            Heading::make('Mailing Address')->hideFromDetail(),
            Text::make('Building Name', 'mbldg_name')->hideFromIndex()->hideFromDetail(),
            Place::make('Address', 'maddress')->hideFromIndex()->hideFromDetail(),
            Text::make('City', 'mcity')->hideFromIndex()->hideFromDetail(),
            Text::make('Postal Code', 'mpostcode')->hideFromIndex()->hideFromDetail(),
            
            Heading::make('Additional Information')->hideFromDetail(),
            Text::make('Date Founded', 'date_founded')->hideFromIndex()->hideFromDetail(),
            Number::make('Total Members', 'totalMembership')->hideFromIndex()->hideFromDetail(),
            Number::make('Ave. Weekly Attendance', 'aveWeeklyAttendance')->hideFromIndex()->hideFromDetail(),
            Number::make('Number Of Reverends', 'numberOfReverends')->hideFromIndex()->hideFromDetail(),
            Number::make('Number Of Preachers', 'numberOfPreachers')->hideFromIndex()->hideFromDetail(),
            
            Textarea::make('Mission', 'mission')->hideFromIndex()->hideFromDetail(),
            Textarea::make('Mission (Chinese)', 'mission_chi')->placeholder('Mission in Chinese (if any)')->hideFromIndex()->hideFromDetail(),
            Textarea::make('Vision', 'vision')->hideFromIndex()->hideFromDetail(),
            Textarea::make('Vision (Chinese)', 'vision_chi')->placeholder('Vision in Chinese (if any)')->hideFromIndex()->hideFromDetail(),
            
            Tabs::make('About the Church', [

                Tab::make('Primary Address', [
                    Text::make('Building Name', 'bldg_name')
                        ->hideFromIndex()
                        ->hideWhenCreating()
                        ->hideWhenUpdating(),
                    Place::make('Address', 'address')
                        ->hideFromIndex()
                        ->hideWhenCreating()
                        ->hideWhenUpdating(),
                    Text::make('City')
                        ->hideFromIndex()
                        ->hideWhenCreating()
                        ->hideWhenUpdating(),
                    Text::make('Postal Code', 'postcode')
                        ->hideFromIndex()
                        ->hideWhenCreating()
                        ->hideWhenUpdating(),
                ]),

                Tab::make('Mailing Address', [
                    Text::make('Building Name', 'mbldg_name')
                        ->hideFromIndex()
                        ->hideWhenCreating()
                        ->hideWhenUpdating(),
                    Place::make('Address', 'maddress')
                        ->hideFromIndex()
                        ->hideWhenCreating()
                        ->hideWhenUpdating(),
                    Text::make('City', 'mcity')
                        ->hideFromIndex()
                        ->hideWhenCreating()
                        ->hideWhenUpdating(),
                    Text::make('Postal Code', 'mpostcode')
                        ->hideFromIndex()
                        ->hideWhenCreating()
                        ->hideWhenUpdating(),
                ]),

                Tab::make('Additional Information', [
                    Text::make('Date Founded', 'date_founded')
                        ->hideFromIndex()
                        ->hideWhenCreating()
                        ->hideWhenUpdating(),
                    Number::make('Total Members', 'totalMembership')
                        ->hideFromIndex()
                        ->hideWhenCreating()
                        ->hideWhenUpdating(),
                    Number::make('Ave. Weekly Attendance', 'aveWeeklyAttendance')
                        ->hideFromIndex()
                        ->hideWhenCreating()
                        ->hideWhenUpdating(),
                    Number::make('Number Of Reverends', 'numberOfReverends')
                        ->hideFromIndex()
                        ->hideWhenCreating()
                        ->hideWhenUpdating(),
                    Number::make('Number Of Preachers', 'numberOfPreachers')
                        ->hideFromIndex()
                        ->hideWhenCreating()
                        ->hideWhenUpdating(),
                ]),

                Tab::make('Mission', [
                    Textarea::make('Mission', 'mission')
                        ->hideFromIndex()
                        ->hideWhenCreating()
                        ->hideWhenUpdating(),
                    Textarea::make('Mission (Chinese)', 'mission_chi')
                        ->hideFromIndex()
                        ->hideWhenCreating()
                        ->hideWhenUpdating()
                ]),

                Tab::make('Vision', [
                    Textarea::make('Vision', 'vision')
                        ->hideFromIndex()
                        ->hideWhenCreating()
                        ->hideWhenUpdating(),
                    Textarea::make('Vision (Chinese)', 'vision_chi')
                        ->hideFromIndex()
                        ->hideWhenCreating()
                        ->hideWhenUpdating()
                ])
                
            ]),

            Tabs::make('Contact Details', [
                HasMany::make('Contact Details', 'contacts_details', 'App\Nova\ContactDetails')
                    ->hideFromIndex(),
                HasMany::make('Service Schedules', 'service_schedules', 'App\Nova\ServiceSchedule')
                    ->hideFromIndex(),
                HasMany::make('Pastors & Staffs', 'pastors_staffs', 'App\Nova\PastorStaff')
                    ->hideFromIndex(),
            ])->defaultSearch(true),

            (new Panel('Manage Status', [

                Boolean::make('Is Approved', 'is_approved')
                    ->onlyOnForms()
                    ->showOnDetail()
                    ->canSee(function(Request $request) {
                        return $request->user()->role_id == 1;
                    }),

                Boolean::make('Is Published', 'is_published')
                    ->onlyOnForms()
                    ->showOnDetail(),

                Boolean::make('Is Searchable', 'is_searchable')
                    ->onlyOnForms()
                    ->showOnDetail(),

            ])),

            BelongsTo::make('User')
                ->canSee(function(Request $request) {
                    return $request->user()->role_id == 1;
                })
                ->searchable()
                ->hideFromIndex(),

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
        return [
            
            // (new NewChurches())
            //     ->canSee(function(Request $request) {
            //         return $request->user()->role_id == 1;
            //     }),

        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [

            (new Denomination)
                ->canSee(function(Request $request) {
                    return $request->user()->role_id == 1;
                }),
        
            new Approved,

            new Published,

            new Searchable,
        
        ];
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

            (new UpdateStatuses)
                ->onlyOnIndex(),
            
            (new AddServiceSchedule)
                ->showOnTableRow()

            // (new AssignDenomination)
            //     ->onlyOnIndex(),
            
            // (new AssignUser)
            //     ->showOnTableRow()
            //     ->canSee(function() {
            //         return $this->resource->user_id === NULL;
            //     })

        ];
    }
}
