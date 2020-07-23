<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfile extends FormRequest
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
            'place' => 'required',
            'job' => 'required',
            'personal_id' => 'required',
            'issued_date' => 'required',
            'issued_by' => 'required',
            'supervisor_name' => 'required',
            'supervisor_dob' => 'required',
            'detail' => 'required',
            'google_plus_name' => 'required',
            'google_plus_link' => 'required',
            'aim_link' => 'required',
            'window_live_link' => 'required',
            'yahoo_link' => 'required',
            'icq_link' => 'required',
            'skype_link' => 'required',
            'google_talk_link' => 'required',
            'facebook_link' => 'required',
            'twitter_link' => 'required',
        ];
    }
}
