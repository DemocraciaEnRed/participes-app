<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {   
        // Already checking via middleware
        // https://stackoverflow.com/questions/37184430/what-is-the-purpose-of-the-authorize-method-in-a-request-class-in-laravel
        // https://stackoverflow.com/posts/37184701/revisions
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:550',
            'status' => 'required|string|in:ongoing,delayed,inactive',
            'indicator' => 'required|string|max:550',
            'indicator_goal' => 'integer|min:1',
            'indicator_progress' => 'integer|min:0',
            'indicator_unit' => 'required|string|max:550',
            'indicator_frequency' => 'string|max:550',
            'source' => 'string|max:550',
            'milestones' => 'array',
            'milestones.*' => 'required|string|max:550',
        ];
    }
}
