<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBuyLicenseRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'trello_board_1' => 'required',
            'trello_board_2' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'trello_board_1' => 'Board is required',
            'trello_board_2' => 'Board is required',
        ];
    }
}
