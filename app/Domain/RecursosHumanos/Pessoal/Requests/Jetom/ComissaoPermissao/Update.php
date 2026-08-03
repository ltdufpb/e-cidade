<?php

namespace App\Domain\RecursosHumanos\Pessoal\Requests\Jetom\ComissaoPermissao;

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
        return [
            'id' => 'required|integer|exists:jetompermissao,rh251_sequencial',
            'comissao' => 'required|filled|integer',
            'matricula' => [
                'required',
                'filled',
                'integer',
                Rule::unique(
                    'jetompermissao',
                    'rh251_matricula'
                )
                ->where(
                    "rh251_comissao",
                    $this->request->get('comissao')
                ),
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
            "id.required" => mb_convert_encoding("Código da Permissão não informado.", 'UTF-8', 'ISO-8859-1'),
            "id.integer" => mb_convert_encoding("Código inválido da Permissão.", 'UTF-8', 'ISO-8859-1'),
            "id.exists" => mb_convert_encoding("Permissão não encontrada.", 'UTF-8', 'ISO-8859-1'),

            "comissao.required" => mb_convert_encoding("Comissão não informada para o cadastro da comissão.", 'UTF-8', 'ISO-8859-1'),
            "comissao.filled" => mb_convert_encoding("O código da Comissão esta vazio.", 'UTF-8', 'ISO-8859-1'),
            "comissao.integer" => mb_convert_encoding("Código inválido da Comissão.", 'UTF-8', 'ISO-8859-1'),

            "matricula.required" => mb_convert_encoding("É necessário informar a Matricula da comissão.", 'UTF-8', 'ISO-8859-1'),
            "matricula.filled" => mb_convert_encoding("Matricula não pode estar vazia.", 'UTF-8', 'ISO-8859-1'),
            "matricula.integer" => mb_convert_encoding("Matricula inválida.", 'UTF-8', 'ISO-8859-1'),
            "matricula.unique" => mb_convert_encoding("Esta matricula já tem cadastro na permissão.", 'UTF-8', 'ISO-8859-1'),
        ];
    }
}
