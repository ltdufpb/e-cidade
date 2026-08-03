<?php
namespace App\Domain\Tributario\ISSQN\Requests\AlvaraEventos\AlvaraEvento;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
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
     * @return array
     */
    public function rules()
    {
        return [
            'q170_tipoalvara'        => 'required|filled|integer',
            'q170_ordemservico'      => 'required|filled|integer|unique:alvaraevento',
            'q170_certidaobombeiro'  => 'required|filled|string',
            'q170_dataemissao'       => 'nullable|date',
            'q170_estimativapublico' => 'nullable|integer',
            'q170_observacao'        => 'required|filled|string',
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

            "q170_tipoalvara.required"       => mb_convert_encoding("Tipo de alvará não informado.", 'UTF-8', 'ISO-8859-1'),
            "q170_tipoalvara.filled"         => mb_convert_encoding("Tipo de alvará informado está vazia.", 'UTF-8', 'ISO-8859-1'),
            "q170_tipoalvara.integer"        => mb_convert_encoding("Tipo de alvará inválido.", 'UTF-8', 'ISO-8859-1'),

            "q170_ordemservico.unique"       => mb_convert_encoding("Já existe um alvara de evento para a ordem de serviço.", 'UTF-8', 'ISO-8859-1'),
            "q170_ordemservico.required"     => mb_convert_encoding("Ordem de serviço não informada.", 'UTF-8', 'ISO-8859-1'),
            "q170_ordemservico.filled"       => mb_convert_encoding("Ordem de serviço informada está vazia.", 'UTF-8', 'ISO-8859-1'),
            "q170_ordemservico.integer"      => mb_convert_encoding("Ordem de serviço inválida.", 'UTF-8', 'ISO-8859-1'),

            "q170_certidaobombeiro.required" => mb_convert_encoding("Certidão de bombeiros não informada.", 'UTF-8', 'ISO-8859-1'),
            "q170_certidaobombeiro.filled"   => mb_convert_encoding("Certidão de bombeiros informada está vazia.", 'UTF-8', 'ISO-8859-1'),
            "q170_certidaobombeiro.string"   => mb_convert_encoding("Certidão de bombeiros inválida.", 'UTF-8', 'ISO-8859-1'),

            "q170_dataemissao.date"          => mb_convert_encoding("Data de emissao inválida.", 'UTF-8', 'ISO-8859-1'),

            "q170_estimativapublico.integer" => mb_convert_encoding("Estimativa de público inválida.", 'UTF-8', 'ISO-8859-1'),

            "q170_observacao.required"       => mb_convert_encoding("Observação não informada.", 'UTF-8', 'ISO-8859-1'),
            "q170_observacao.filled"         => mb_convert_encoding("Observação informada está vazia.", 'UTF-8', 'ISO-8859-1'),
            "q170_observacao.string"         => mb_convert_encoding("Observação inválida.", 'UTF-8', 'ISO-8859-1'),

        ];
    }
}
