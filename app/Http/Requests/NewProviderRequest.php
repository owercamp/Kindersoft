<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewProviderRequest extends FormRequest
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
            'numberdocument' => 'required|integer|unique:providers',
            'numbercheck' => 'nullable|integer',
            'namecompany' => 'required|string',
            'address' => 'nullable|string',
            'cityhome_id' => 'required|integer',
            'locationhome_id' => 'nullable|integer',
            'dictricthome_id' => 'nullable|integer',
            'phoneone' => 'required|integer',
            'phonetwo' => 'nullable|integer',
            'whatsapp' => 'nullable|integer',
            'emailone' => 'nullable|string|unique:providers',
            'emailtwo' => 'nullable|string'
        ];
    }
}
