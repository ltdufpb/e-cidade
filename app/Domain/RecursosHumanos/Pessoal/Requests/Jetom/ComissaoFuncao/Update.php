<?php

namespace App\Domain\RecursosHumanos\Pessoal\Requests\Jetom\ComissaoFuncao;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class Update extends BaseFormRequest
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
            'id' => 'required|integer|exists:jetomcomissaofuncao,rh246_sequencial',
            'comissao' => [
                'required',
                'integer',
                'exists:jetomcomissao,rh242_sequencial',
            ],
            'funcao' => [
                'required',
                'integer',
                'exists:jetomfuncao,rh241_sequencial',
                Rule::unique("jetomcomissaofuncao", "rh246_funcao")
                    ->where("rh246_comissao", $this->request->get('comissao'))
                    ->whereNot("rh246_sequencial", $this->request->get('id'))
            ],
            'quantidade' => [
                'integer',
                'required'
            ],
        ];
    }

    /**
     * @param  array $errors
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
            "id.required" => mb_convert_encoding("Código da configuração da função da comissão não informado.", 'UTF-8', 'ISO-8859-1'),
            "id.integer" => mb_convert_encoding("Código inválido da configuração da função da comissão.", 'UTF-8', 'ISO-8859-1'),
            "id.exists" => mb_convert_encoding("Configuração da função da comissão não encontrada.", 'UTF-8', 'ISO-8859-1'),
            "comissao.required" => mb_convert_encoding("Código da comissão não informado.", 'UTF-8', 'ISO-8859-1'),
            "comissao.integer" => mb_convert_encoding("Código inválido da comissão.", 'UTF-8', 'ISO-8859-1'),
            "comissao.exists" => mb_convert_encoding("Comissão não encontrada", 'UTF-8', 'ISO-8859-1'),
            "funcao.required" => mb_convert_encoding("Código da função não informado.", 'UTF-8', 'ISO-8859-1'),
            "funcao.integer" => mb_convert_encoding("Código inválido da função.", 'UTF-8', 'ISO-8859-1'),
            "funcao.exists" => mb_convert_encoding("Função não encontrada.", 'UTF-8', 'ISO-8859-1'),
            "funcao.unique" => mb_convert_encoding("Função já cadastrada para a comissão.", 'UTF-8', 'ISO-8859-1'),
            "quantidade.required" => mb_convert_encoding("Quantidade não informada.", 'UTF-8', 'ISO-8859-1'),
            "quantidade.integer" => mb_convert_encoding("Quantidade inválida", 'UTF-8', 'ISO-8859-1'),
        ];
    }
}
