<?php

namespace App\Domain\RecursosHumanos\Pessoal\Requests\Jetom\Funcao;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseFormRequest;

class Store extends BaseFormRequest
{
    /**
     * @return bool
     */
    #[\Override]
    public function authorize()
    {
        return true;
    }

    /**
     * @param Request $request
     * @return array|bool
     */
    public function rules(Request $request)
    {
        return $this->preValidacaoRule() ?: [
            'descricao' => [
                'string',
                'required',
                Rule::unique('jetomfuncao', 'rh241_descricao')->where("rh241_instit", $request->instituicao),
            ],
            'instituicao' => 'required|integer'
        ];
    }

    /**
     * @param array $errors
     * @return DBJsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        $mensagem = mb_convert_encoding($errors[array_keys($errors)[0]][0], 'ISO-8859-1');
        return new DBJsonResponse($errors, $mensagem, 406);
    }

    /**
     * @return array
     */
    #[\Override]
    public function messages()
    {
        return [
            'instituicao.required' => mb_convert_encoding('Instituição não informada.', 'UTF-8', 'ISO-8859-1'),
            'instituicao.integer' => mb_convert_encoding('Código da instituição inválido.', 'UTF-8', 'ISO-8859-1'),
            'descricao.required' => mb_convert_encoding('Descrição da função não informada.', 'UTF-8', 'ISO-8859-1'),
            'descricao.string' => mb_convert_encoding('Descrição inválida para a função.', 'UTF-8', 'ISO-8859-1'),
            'descricao.unique' => mb_convert_encoding('Descrição da função já cadastrada.', 'UTF-8', 'ISO-8859-1')
        ];
    }
}
