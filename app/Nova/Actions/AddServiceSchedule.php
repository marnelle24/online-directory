<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class AddServiceSchedule extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Get the displayable label of the button.
     *
     * @return string
     */

    // public $name = '+ Service';

    public function name() {
        return 'Add Service';
    }

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model){
            
            DB::table('service_schedules')->insert([
                'church_identifier' => $model->id,
                'type' => $fields->type,
                'language' => $fields->language,
                'scheduleDay' => $fields->scheduleDay,
                'scheduleHour' => $fields->scheduleHour,
                'scheduleMinutes' => $fields->scheduleMinutes,
                'amOrPm' => $fields->amOrPm,
            ]);

            $this->markAsFinished($model);

        }
        
        return Action::message('New service schedule added successfully');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {

        return [

            Text::make('Type', 'type')
                ->rules('required'),

            Select::make('Language', 'language')
                // ->searchable()
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
                ->rules('required'),    

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
                ->rules('required'),

            Number::make('Hour', 'scheduleHour')
                ->min(1)
                ->max(12)
                ->rules('required', 'min:1', 'max:12'),
            
            Number::make('Minutes', 'scheduleMinutes')
                ->min(0)
                ->max(59)
                ->rules('required', 'min:0', 'max:60'),
            
            Select::make('AM/PM', 'amOrPm')
                ->default('AM')
                ->options([
                    'AM' => 'AM',
                    'PM' => 'PM'
                ])
                ->rules('required'),

        ];
    }
}
