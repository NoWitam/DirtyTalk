<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class FileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // czy to zdjecia bota pokazujacego sie w szukanych matchach
        $showedMatch = Cache::get('showed_match.' . Auth::id());
        if($showedMatch && $this->file->owner->id == $showedMatch['id']) {
            return true;
        }

        //czy to zdjecia bota z którym mamy pare
        if ($this->file->owner->matches->contains(Auth::user())) {
            return true;
        }

        // nic nie pasuje
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
