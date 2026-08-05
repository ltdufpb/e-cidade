<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Validator;

class BaseFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * PrÃ© ValidaÃ§Ã£o para Rules dentro de Form Requests
     *
     * @return array|bool
     */
    protected function preValidacaoRule()
    {

        $instituicao = empty($this->request->get('instituicao')) ? "abc" : $this->request->get('instituicao') ;

        return !is_numeric($instituicao) ? ['instituicao' => 'required|integer',] : false ;
    }

    #[\Override]
    public function messages()
    {
        return [
            "instituicao.required" => mb_convert_encoding("Instituição obrigatória.", 'UTF-8', 'ISO-8859-1'),
            "instituicao.integer"  => mb_convert_encoding("Instituição precisa ser um número.", 'UTF-8', 'ISO-8859-1')
        ];
    }
}
