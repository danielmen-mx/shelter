<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class Guest extends FormRequest
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

    protected function prepareForValidation()
    {
        $this->merge([
            'first_name'       => $this->validateString($this->first_name),
            'second_name'      => $this->validateString($this->second_name),
            'first_last_name'  => $this->validateString($this->first_last_name),
            'second_last_name' => $this->validateString($this->second_last_name),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name'       => 'required|max:255',
            'second_name'      => 'nullable|max:255',
            'first_last_name'  => 'required|max:255',
            'second_last_name' => 'nullable|max:255',
            'assistance'       => 'required|boolean',
        ];
    }

    private function validateString($string)
    {
        $slugged = ucfirst(Str::slug($string));

        if (str_contains($slugged, '-')) {
            $slugsWUnderscore = explode('-', $slugged);
            $newString = collect($slugsWUnderscore)->map(function ($slug) {
                return ucfirst($slug);
            });

            $slugged = implode(' ', $newString->all());
        }

        return $slugged;
    }
}
