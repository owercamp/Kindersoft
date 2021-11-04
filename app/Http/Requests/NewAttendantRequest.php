<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewAttendantRequest extends FormRequest
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
            'typedocument_id' => 'required|integer',
            'numberdocument' => 'required|integer|unique:attendants',
            'firstname' => 'required|string',
            'secondname' => 'nullable|string',
            'threename' => 'required|string',
            'fourname' => 'nullable|string',
            'address' => 'nullable|string',
            'cityhome_id' => 'required|integer',
            'locationhome_id' => 'nullable|integer',
            'dictricthome_id' => 'nullable|integer',
            'phoneone' => 'nullable|integer',
            'phonetwo' => 'nullable|integer',
            'whatsapp' => 'nullable|integer',
            'emailone' => 'nullable|string|unique:attendants',
            'emailtwo' => 'nullable|string',
            'bloodtype_id' => 'nullable|integer',
            'gender' => 'required|string',
            'profession_id' => 'nullable|integer',
            'company' => 'nullable|string',
            'position' => 'nullable|string',
            'antiquity' => 'nullable|date',
            'addresscompany' => 'nullable|string',
            'citycompany_id' => 'required|integer',
            'locationcompany_id' => 'nullable|integer',
            'dictrictcompany_id' => 'nullable|integer'
        ];
    }
}
