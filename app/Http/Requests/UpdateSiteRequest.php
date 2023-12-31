<?php

namespace App\Http\Requests;

use App\Models\Site;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'nullable|max:255',
            'address' => 'required|max:255|url|unique:' . Site::class . ',address,' . $this->route('site'),
        ];
    }
}
