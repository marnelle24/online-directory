<?php

namespace App\Nova\Actions;

use App\Models\Denomination;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;

class AssignDenomination extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $count = 0;

        foreach ($models as $model){
            $model->update([
                'denomination_id' => $fields->denomination
            ]);

            $this->markAsFinished($model);

            $count++;
        }

        return Action::message($count . ' records updated successfully');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [

            Select::make('Denomination')
                ->searchable()
                ->options(function () {
                    return array_filter(Denomination::where('status', true)->pluck('name', 'id')->toArray());
                }),

        ];
    }
}
