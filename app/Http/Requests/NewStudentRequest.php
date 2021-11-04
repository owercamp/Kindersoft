<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewStudentRequest extends FormRequest
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
            'typedocument_id' => 'required|integer', //required
            'numberdocument' => 'required|integer|unique:students', //required
            'firstname' => 'required|string', //required
            'secondname' => 'nullable|string',
            'threename' => 'required|string', //required
            'fourname' => 'nullable|string',
            'birthdate' => 'required|date', //required
            'yearsold' => 'required|string', //required
            'monthold' => 'required|string', //required
            'address' => 'nullable|string',
            'cityhome_id' => 'required|integer', //required
            'locationhome_id' => 'nullable|integer',
            'dictricthome_id' => 'nullable|integer',
            'bloodtype_id' => 'required|integer', //required
            'gender' => 'required|string', //required
            'additionalHealt ' => 'nullable|string',
            'additionalHealtDescription' => 'nullable|string'
        ];
    }
}
