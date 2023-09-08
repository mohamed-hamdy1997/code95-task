<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateTurnsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'players_num' => 'nullable|numeric|min:1|max:26',
            'turns_num' => 'nullable|numeric|min:1|max:15',
            'starting_player' => 'nullable|alpha|string|size:1',
        ];
    }
}
