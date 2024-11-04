<?php

namespace App\Http\Requests;

use App\Helpers\Format;
use Illuminate\Foundation\Http\FormRequest;

class ContactForm extends FormRequest
{

    protected $redirectRoute = 'contatos';

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
        $input = parent::getInputSource();

        $input->set('phone', Format::filterNumbers($this->input('phone')));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'phone' => 'required|min:10|max:11',
            'email' => 'required|email|max:255',
            'message' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório',
            'name.max' => 'O nome deve ter no máximo 255 caracteres',
            'phone.required' => 'O telefone é obrigatório',
            'phone.min' => 'O telefone deve ter no mínimo 10 dígitos',
            'phone.max' => 'O telefone deve ter no máximo 11 dígitos',
            'email.required' => 'O email é obrigatório',
            'email.email' => 'O email deve ser válido',
            'email.max' => 'O email deve ter no máximo 255 caracteres',
            'message.required' => 'A mensagem é obrigatória',
            'g-recaptcha-response.required' => 'Por favor, complete o reCAPTCHA',
            'g-recaptcha-response.captcha' => 'A verificação do reCAPTCHA tente novamente.'
        ];
    }
}
