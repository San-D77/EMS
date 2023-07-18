<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            "title" => "required|string|max:255",
            "slug"  => "required|string|max:255|unique:roles,slug,". $this->route("role")?->id,
        ];
    }

    public function prepareForValidation(){
        $this->merge([
            "slug" => $this->route("role")?->slug ?? str()->slug($this->title),
        ]);
    }
}
