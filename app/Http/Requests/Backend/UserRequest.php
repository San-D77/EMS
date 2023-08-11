<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            "name" => "required|string|max:255",
            "email" => "required|string|email|max:255|unique:users,email," . $this->route("user")?->id,
            "password" => $this->password ?"required_without:id|min:6":'',
            "alias_name" => "required|string|max:255",
            "role_id" => "required|exists:roles,id",
            "gender" => "required",
            "designation" => "required|string|max:255",
            "employment_type" => "required|string|max:255",
            "slug" => "required|string|max:255|unique:users,slug," . $this->route("user")?->id,
            "avatar" => "nullable|image|mimes:jpeg,png,jpg,gif,svg",
        ];
    }

    protected function prepareForValidation()
    {

        $this->merge([
            "slug" => $this->route("user")?->slug ?? str()->slug($this->name),
            "id" => $this->route("user")?->id ?? null,
            "password" => isset($this->password)? bcrypt($this->password): '',
        ]);


    }
}
