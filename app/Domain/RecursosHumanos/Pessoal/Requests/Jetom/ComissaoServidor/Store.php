<?php

namespace App\Domain\RecursosHumanos\Pessoal\Requests\Jetom\ComissaoServidor;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Http\Requests\BaseFormRequest;
use App\Domain\RecursosHumanos\Pessoal\Model\Jetom\ComissaoServidor;
use App\Domain\RecursosHumanos\Pessoal\Model\Jetom\ComissaoFuncao;
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
            ],
            'matricula' => 'required|integer',
            'mesinicio' => 'integer|between:1,12',
            'mesfim' => 'integer|between:1,12',
            'anoinicio' => 'integer|min:' . date("Y"),
            'anofim' => 'integer',
            'funcao' => [
                'required',
                'integer',
                'exists:jetomfuncao,rh241_sequencial',
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
            "comissao.exists" => mb_convert_encoding("Comissão não encontrada.", 'UTF-8', 'ISO-8859-1'),
            "funcao.required" => mb_convert_encoding("Função do servidor não informada.", 'UTF-8', 'ISO-8859-1'),
            "funcao.integer" => mb_convert_encoding("Função inválida do servidor.", 'UTF-8', 'ISO-8859-1'),
            "funcao.exists" => mb_convert_encoding("Função não encontrada.", 'UTF-8', 'ISO-8859-1'),
            "funcao.unique" => mb_convert_encoding("Função já cadastrada para o servidor.", 'UTF-8', 'ISO-8859-1'),
            "matricula.required" => mb_convert_encoding("Matricula não informada.", 'UTF-8', 'ISO-8859-1'),
            "matricula.integer" => mb_convert_encoding("Matricula inválida.", 'UTF-8', 'ISO-8859-1'),
            "mesinicio.integer" => mb_convert_encoding("Mês de inicio da função inválido.", 'UTF-8', 'ISO-8859-1'),
            "mesinicio.between" => mb_convert_encoding("Mês de inicio da função deve ser entre 1 e 12.", 'UTF-8', 'ISO-8859-1'),
            "mesfim.integer" => mb_convert_encoding("Mês de termino da função inválido.", 'UTF-8', 'ISO-8859-1'),
            "mesfim.between" => mb_convert_encoding("Mês de termino da função deve ser entre 1 e 12.", 'UTF-8', 'ISO-8859-1'),
            "anoinicio.integer" => mb_convert_encoding("Ano de inicio da função inválido.", 'UTF-8', 'ISO-8859-1'),
            "anoinicio.min" => mb_convert_encoding("Ano inicial não pode ser inferior a " . date("Y") . ".", 'UTF-8', 'ISO-8859-1'),
            "anofim.integer" => mb_convert_encoding("Ano de termino da função inválido.", 'UTF-8', 'ISO-8859-1'),
        ];
    }
}
