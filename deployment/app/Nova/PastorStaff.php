<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use OwenMelbz\RadioField\RadioButton;

class PastorStaff extends Resource
{
    public static $group = 'CHRUCH';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\PastorStaff::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public function title()
    {
        return $this->first_name . ' ' . $this->family_name;
    }

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public function subtitle()
    {
        return $this->church->name;
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Pastors/Staffs');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Pastor/Staff');
    }


    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title',
        'first_name',
        'given_name',
        'family_name',
        'position'
    ];

    /**
     * The icon of the resource.
     *
     * @return string
     */
    public static function icon()
    {
        return view('nova::icons.icon-pastorstaff')->render();
    }

    /**
     * Custom query for searching 
     * */ 
    public static function indexQuery(NovaRequest $request, $query)
    {
        if($request->user()->role_id !== 1)
        {
            $query->select('pastor_staff.*', 'chu.name');
            $query->join('churches as chu', 'pastor_staff.church_id', '=', 'chu.id');
            $query->where('chu.user_id', '=', $request->user()->id);
        } 
        else
        {
            $query->select('pastor_staff.*', 'chu.name');
            $query->join('churches as chu', 'pastor_staff.church_id', '=', 'chu.id');
        }

        return $query;
        
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
            // ID::make(__('ID'), 'id')->sortable(),

            BelongsTo::make('Church','church')
                ->searchable()
                ->readonly(function() {
                    return $this->resource->exists;
                }),
            
            Text::make('Full Name', function() {
                return ($this->title === 'Others') || ($this->title === 'Select') ? $this->first_name . ' ' . $this->family_name : $this->title  . ' ' . $this->first_name . ' ' . $this->family_name;
            })
            ->onlyOnIndex(),

            RadioButton::make('Pastor or Staff?', 'type')
                ->options([
                    'pastor' => 'Pastor',
                    'staff'  => 'Staff'
                ])
                ->default('staff')
                ->hideFromDetail()
                ->hideFromIndex(),

            Text::make('Type', 'type')
                ->hideWhenUpdating()
                ->hideWhenCreating(),

            Select::make('Title')
                ->options([
                    'Archdeacon' => 'Archdeacon',
                    'Archbishop' => 'Archbishop',
                    'Bishop Dr' => 'Bishop Dr',
                    'Bishop' => 'Bishop',
                    'Canon' => 'Canon',
                    'Deacon' => 'Deacon',
                    'Deaconess' => 'Deaconess',
                    'Dr' => 'Dr',
                    'Elder' => 'Elder',
                    'Mdm' => 'Mdm',
                    'Ms' => 'Ms',
                    'Mr' => 'Mr',
                    'Mrs' => 'Mrs',
                    'Preacher' => 'Preacher',
                    'Pastor' => 'Pastor',
                    'Rev' => 'Rev',
                    'Rev Canon' => 'Rev Canon',
                    'Rev Canon Dr' => 'Rev Canon Dr',
                    'Rev Dr' => 'Rev Dr',
                    'Rev Fr' => 'Rev Fr',
                    'Rt Rev' => 'Rt Rev',
                    'Sister' => 'Sister',
                    'Brother' => 'Brother',
                    'The Very Rev' => 'The Very Rev',
                    'The Most Rev' => 'The Most Rev',
                    'Colonel' => 'Colonel',
                    'Lieut-Colonel' => 'Lieut-Colonel',
                    'Captain' => 'Captain',
                    'Major' => 'Major',
                    'Others' => 'Others'
                ])
                ->searchable()
                ->hideFromIndex()
                ->rules('required'),

            Text::make('Title (in chinese)', 'title_chi')
                ->placeholder('Title in Chinese (if any)')
                ->hideFromIndex(),
            
            Text::make('First Name', 'first_name')
                ->rules('required')
                ->placeholder('First name')
                ->hideFromIndex(),

            Text::make('Given Name', 'given_name')
                ->placeholder('Given name')
                ->hideFromIndex(),
            
            Text::make('Given Name (in chinese)', 'given_name_chi')
                ->placeholder('Given name in Chinese (if any)')
                ->hideFromIndex(),

            Text::make('Family Name', 'family_name')
                ->placeholder('Family name')
                ->rules('required')
                ->hideFromIndex(),
            
            Text::make('Family Name (in chinese)', 'family_name_chi')
                ->placeholder('Family name in Chinese (if any)')
                ->hideFromIndex(),

            new Panel('Contact Number', [

                Text::make('Phone Number', 'phone')
                    ->placeholder('000-000'),
                
                Text::make('Position (Chinese)', 'position_chi')
                    ->onlyOnForms(),

                Select::make('Position', 'position')
                    ->options([
                        'Administrator' => 'Administrator',
                        'Admin Staff' => 'Admin Staff',
                        'Associate Minister' => 'Associate Minister',
                        'Bishop' => 'Bishop',
                        'Chairman' => 'Chairman',
                        'Cell leader' => 'Cell leader',
                        'Chief Executive Officer' => 'Chief Executive Officer',
                        'Clergy' => 'Clergy',
                        'Dean' => 'Dean',
                        'Director' => 'Director',
                        'Elder' => 'Elder',
                        'Executive Director' => 'Executive Director',
                        'Executive Officer' => 'Executive Officer',
                        'Executive Pastor' => 'Executive Pastor',
                        'Founding Pastor' => 'Founding Pastor',
                        'General Secretary' => 'General Secretary',
                        'General Superintendent' => 'General Superintendent',
                        'Head of Department' => 'Head of Department',
                        'Head of Ministry' => 'Head of Ministry',
                        'Lay Pastor' => 'Lay Pastor',
                        'Manager' => 'Manager',
                        'Ministry Staff' => 'Ministry Staff',
                        'Moderator' => 'Moderator',
                        'National Director' => 'National Director',
                        'Office Manager' => 'Office Manager',
                        'Office Secretary' => 'Office Secretary',
                        'Operations Manager' => 'Operations Manager',
                        'Others' => 'Others',
                        'Pastor' => 'Pastor',
                        'Pastor (Commanding Officer)' => 'Pastor (Commanding Officer)',
                        'Pastoral Staff' => 'Pastoral Staff',
                        'Personal Asst to Senior Pastor' => 'Personal Asst to Senior Pastor',
                        'Preacher' => 'Preacher',
                        'President' => 'President',
                        'Priest' => 'Priest',
                        'Principal' => 'Principal',
                        'Secretary' => 'Secretary',
                        'Senior Minister' => 'Senior Minister',
                        'Senior Pastor' => 'Senior Pastor',
                        'Staff' => 'Staff',
                        'Vicar' => 'Vicar',
                        'Vice President' => 'Vice President',
                        'Youth Worker' => 'Youth Worker',
                    ])
                    ->searchable()
                    ->rules('required')

                    ]),

                    Boolean::make('Status', 'status')
                        ->onlyOnIndex(),
                    
                    Boolean::make('Still Active?', 'status')
                        ->hideFromIndex()
            
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
