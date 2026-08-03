<?php

namespace App\Domain\RecursosHumanos\Pessoal\Requests\Jetom\Comissao;

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
     * @return array|bool
     */
    public function rules()
    {

        // dd($this->request->all());
        return $this->preValidacaoRule() ?: [
            'id' => 'required|integer|exists:jetomcomissao,rh242_sequencial',
            'instituicao' => [
                'required',
                'integer'
            ],
            'descricao' => [
                'string',
                'required',
                'max:50',
                Rule::unique(
                    'jetomcomissao',
                    'rh242_descricao'
                )
                ->where(
                    "rh242_instit",
                    $this->request->get('instituicao')
                )
                ->whereNot('rh242_sequencial', $this->request->get('id')),
            ],
        ];
    }

    /**
     * @param array $errors
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
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
            "id.required" => mb_convert_encoding("Código da comissão não informado.", 'UTF-8', 'ISO-8859-1'),
            "id.integer" => mb_convert_encoding("Código inválido da comissão.", 'UTF-8', 'ISO-8859-1'),
            "id.exists" => mb_convert_encoding("Comissão não encontrada.", 'UTF-8', 'ISO-8859-1'),
            "descricao.required" => mb_convert_encoding("Descrição da comissão não informada.", 'UTF-8', 'ISO-8859-1'),
            "descricao.string" => mb_convert_encoding("Descrição inválida da comissão.", 'UTF-8', 'ISO-8859-1'),
            "descricao.unique" => mb_convert_encoding("Encontrada outra comissão com o mesmo nome na instituição.", 'UTF-8', 'ISO-8859-1'),
            "descricao.max" => mb_convert_encoding("Excedido o limite máximo de 50 caracteres para a descrição da comissão.", 'UTF-8', 'ISO-8859-1'),
            "instituicao.required" => mb_convert_encoding("Instituição da comissão não informada.", 'UTF-8', 'ISO-8859-1'),
            "instituicao.integer" => mb_convert_encoding("Instituição inválida da comissão.", 'UTF-8', 'ISO-8859-1'),
        ];
    }
}
