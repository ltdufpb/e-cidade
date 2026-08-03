<?php

namespace App\Domain\RecursosHumanos\Pessoal\Requests\Jetom\Sessao;

use App\Http\Requests\BaseFormRequest;

class SessaoProcessamentoRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    #[\Override]
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
            'ids' => 'required|array',
            'ids.*' => 'integer',
        ];
    }

    protected function getValidatorInstance()
    {
        if ($this->request->get('ids')) {
            $this->merge(['ids' => json_decode($this->get('ids'))]);
        }

        return parent::getValidatorInstance();
    }

    public function response(array $errors)
    {
        $mensagem = $errors[array_keys($errors)[0]][0];

        return response()->json([
            "message" => $mensagem,
            "errors" => $errors,
            "status" => 406
        ], 406);
    }

    #[\Override]
    public function messages()
    {
        return [
            'ids.required' => mb_convert_encoding('É necessário informar as Sessões a serem processadas.', 'UTF-8', 'ISO-8859-1'),
            'ids.array' => mb_convert_encoding('É necessário informar as Sessões a serem processadas.', 'UTF-8', 'ISO-8859-1'),
            'ids.*.integer' => mb_convert_encoding('Código da sessão informada é inválido.', 'UTF-8', 'ISO-8859-1'),
        ];
    }
}
