<?php

namespace App\Domain\RecursosHumanos\Pessoal\Requests\Jetom\ComissaoConfiguracao;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

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
     * @return array
     */
    public function rules()
    {
        return [
            'comissao' => [
                'required',
                'integer',
                'exists:jetomcomissao,rh242_sequencial',
                Rule::unique("jetomcomissaoconfiguracao", "rh243_comissao")
                ->where("rh243_funcao", $this->request->get('funcao'))
                ->where("rh243_tiposessao", $this->request->get('tiposessao'))
            ],
            'funcao' => [
                'required',
                'integer',
                'exists:jetomfuncao,rh241_sequencial'
            ],
            'tiposessao' => [
                'required',
                'integer',
                'exists:jetomtiposessao,rh240_sequencial'
            ],
            'rubrica' => [
                'string',
                'required',
                'max:4'
            ],
            'valor' => [
                'numeric',
                'required',
                'regex:/^\d+(\.\d{1,2})?$/'
            ],
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
            "comissao.required" => mb_convert_encoding("Código da comissão não informado.", 'UTF-8', 'ISO-8859-1'),
            "comissao.integer" => mb_convert_encoding("Código inválido da comissão.", 'UTF-8', 'ISO-8859-1'),
            "comissao.exists" => mb_convert_encoding("Não foi encontrada a comissão com o código informado.", 'UTF-8', 'ISO-8859-1'),
            "comissao.unique" => mb_convert_encoding("Configuração já cadastrada.", 'UTF-8', 'ISO-8859-1'),
            "funcao.required" => mb_convert_encoding("Código da função não informado.", 'UTF-8', 'ISO-8859-1'),
            "funcao.integer" => mb_convert_encoding("Código inválido da função.", 'UTF-8', 'ISO-8859-1'),
            "funcao.exists" => mb_convert_encoding("Função não encontrada.", 'UTF-8', 'ISO-8859-1'),
            "tiposessao.required" => mb_convert_encoding("Tipo de sessão não informado.", 'UTF-8', 'ISO-8859-1'),
            "tiposessao.integer" => mb_convert_encoding("Código inválido para o tipo de sessão informado.", 'UTF-8', 'ISO-8859-1'),
            "tiposessao.exists" => mb_convert_encoding("Tipo de sessão não encontrado.", 'UTF-8', 'ISO-8859-1'),
            "valor.required" => mb_convert_encoding("Valor não informado.", 'UTF-8', 'ISO-8859-1'),
            "valor.numeric" => mb_convert_encoding("Valor inválido.", 'UTF-8', 'ISO-8859-1'),
            "valor.regex" => mb_convert_encoding("O formato do valor esta inválido.", 'UTF-8', 'ISO-8859-1'),
        ];
    }
}
