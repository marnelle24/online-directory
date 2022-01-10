<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class ServiceSchedule extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ServiceSchedule::class;


    // public static $tableStyle = 'tight';

    public static $perPageOptions = [12, 24, 48];

    public static $group = 'CHRUCH';

    /**
     * Change the sidebar label
     */
    public static function label()
    {
        return 'Services';
    }

    /**
     * The icon of the resource.
     *
     * @return string
     */
    public static function icon()
    {
        return view('nova::icons.icon-schedule')->render();
    }

    /**
     * Custom query for searching 
     * */ 
    public static function indexQuery(NovaRequest $request, $query)
    {
        if($request->user()->role_id !== 1)
        {
            $query->select('service_schedules.*', 'chu.name');
            $query->join('churches as chu', 'service_schedules.church_id', '=', 'chu.id');
            $query->where('chu.user_id', '=', $request->user()->id);
        } 
        else
        {
            $query->select('service_schedules.*', 'chu.name');
            $query->join('churches as chu', 'service_schedules.church_id', '=', 'chu.id');
        }

        return $query;
        
    }

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'type';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'type', 'language', 'scheduleDay' , 'chu.name'
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

            Text::make('Type', 'type')
                ->sortable()
                ->rules('required'),

            Select::make('Language', 'language')
                ->searchable()
                ->options([
                    'Bahasa Indonesia'=> 'Bahasa Indonesia',
                    'Burmese'=> 'Burmese',
                    'Cantonese/Hokkien'=> 'Cantonese/Hokkien',
                    'Cantonese/粤语'=> 'Cantonese/粤语',
                    'English'=> 'English',
                    'Hainanese/海南话'=> 'Hainanese/海南话',
                    'Hakka/客家话'=> 'Hakka/客家话',
                    'Hokkien/福建话'=> 'Hokkien/福建话',
                    'Japanese'=> 'Japanese',
                    'Kachin'=> 'Kachin',
                    'Korean'=> 'Korean',
                    'Malay'=> 'Malay',
                    'Mandarin/华语'=> 'Mandarin/华语',
                    'Tagalog'=> 'Tagalog',
                    'Tamil'=> 'Tamil',
                    'Thai'=> 'Thai',
                    'Other'=> 'Other'
                ])
                ->sortable()
                ->rules('required'),

            Text::make('Day', 'scheduleDay')
                ->sortable()
                ->rules('required')
                ->exceptOnForms(),

            Text::make('Time', function() {
                return $this->scheduleHour . ':' . $this->scheduleMinutes .' ' . $this->amOrPm;
                })
                ->exceptOnForms()
                ->rules('required')
                ->sortable(),
    

            (new Panel('Schedule', [

                Select::make('Day', 'scheduleDay')
                    ->options([
                        'Monday' => 'Monday',
                        'Tuesday' => 'Tuesday',
                        'Wednesday' => 'Wednesday',
                        'Thursday' => 'Thursday',
                        'Friday' => 'Friday',
                        'Saturday' => 'Saturday',
                        'Sunday' => 'Sunday'
                    ])
                    ->rules('required')
                    ->onlyOnForms(),

                Number::make('Hour', 'scheduleHour')
                    ->min(1)
                    ->max(12)
                    ->rules('required')
                    ->onlyOnForms(),
                
                Number::make('Minutes', 'scheduleMinutes')
                    ->min(0)
                    ->max(59)
                    ->rules('required')
                    ->onlyOnForms(),
                
                Select::make('AM/PM', 'amOrPm')
                    ->options([
                        'AM' => 'AM',
                        'PM' => 'PM'
                    ])
                    ->rules('required')
                    ->onlyOnForms(),

            ])),

            BelongsTo::make('Church', 'Church')
                ->searchable()

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
