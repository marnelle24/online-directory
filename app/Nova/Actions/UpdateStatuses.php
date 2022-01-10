<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Select;

class UpdateStatuses extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Get the displayable label of the button.
     *
     * @return string
     */

    public $name = 'Update Status';

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
                'is_approved' => $fields->is_approved,
                'is_published' => $fields->is_published,
                'is_searchable' => $fields->is_searchable
            ]);

            $this->markAsFinished($model);
        }

        $msg = 'Records updated successfully';

        return Action::message($msg);

    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [

            Boolean::make('Approve', 'is_approved')
                ->rules('required'),
                
            Boolean::make('Publish', 'is_published')
                ->rules('required'),

            Boolean::make('Searchable', 'is_searchable')
                ->rules('required')

        ];
    }
}
