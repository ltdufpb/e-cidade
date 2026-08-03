<?php

namespace App\Domain\RecursosHumanos\Pessoal\Requests\Jetom\ComissaoTipoSessao;

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
            ],
            'tiposessao' => [
                'required',
                'integer',
                'exists:jetomtiposessao,rh240_sequencial',
                Rule::unique("jetomcomissaotiposessao", "rh249_tiposessao")
                ->where("rh249_comissao", $this->request->get('comissao'))

            ],
            'quantidade' => [
                'integer',
                'required'
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
            "comissao.required" => mb_convert_encoding("Código do tipo de sessão da comissão não informado.", 'UTF-8', 'ISO-8859-1'),
            "comissao.integer" => mb_convert_encoding("Código inválido do tipo de sessão da comissão.", 'UTF-8', 'ISO-8859-1'),
            "comissao.exists" => mb_convert_encoding("Código não encontrado do tipo de sessão da comissão.", 'UTF-8', 'ISO-8859-1'),
            "tiposessao.required" => mb_convert_encoding("Código do tipo de sessão não informado.", 'UTF-8', 'ISO-8859-1'),
            "tiposessao.integer" => mb_convert_encoding("Código inválido do tipo de sessão.", 'UTF-8', 'ISO-8859-1'),
            "tiposessao.exists" => mb_convert_encoding("Código não encontrado do tipo de sessão.", 'UTF-8', 'ISO-8859-1'),
            "tiposessao.unique" => mb_convert_encoding("Tipo de sessão já cadastrado para a comissão.", 'UTF-8', 'ISO-8859-1'),
            "quantidade.required" => mb_convert_encoding("Quantidade não informada.", 'UTF-8', 'ISO-8859-1'),
            "quantidade.integer" => mb_convert_encoding("Quantidade inválida.", 'UTF-8', 'ISO-8859-1'),
        ];
    }
}
