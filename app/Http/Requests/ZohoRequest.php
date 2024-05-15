<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ZohoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //return false;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'dealName' => 'required|max:255',
            'dealStage' => 'required|max:255',
            'accountName' => 'required|max:255',
            'accountWebsite' => 'required|url',
            'accountPhone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ];
    }
}
