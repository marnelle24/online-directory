<?php

namespace App\Nova\Actions;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;

class AssignUser extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Get the displayable label of the button.
     *
     * @return string
     */
    public function label()
    {
        return __('Assign Users');
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
            
            $model->update([
                'user_id' => $fields->user
            ]);

            // DB::table('church_user')->insert([
            //     'user_id' => $fields->user,
            //     'church_id' => $model->id
            // ]);

            $this->markAsFinished($model);

        }
        
        return Action::message('Records updated successfully');

    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [

            Select::make('Users', 'user')
                ->searchable()
                ->rules('required')
                ->options(function() {
                    return array_filter(User::all()->pluck('email', 'id')->toArray());
                })

        ];
    }
}
