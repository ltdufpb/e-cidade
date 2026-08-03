<?php
namespace App\Domain\Patrimonial\Ouvidoria\Requests\Atendimento\Atendimento;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Http\Requests\BaseFormRequest;
use ECidade\Lib\Session\DefaultSession;

class AprovarAtendimento extends BaseFormRequest
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
            DefaultSession::DB_INSTIT => 'required|filled|integer',
            DefaultSession::DB_CODDEPTO => 'required|filled|integer',
            DefaultSession::DB_ID_USUARIO => 'required|filled|integer',
            'numeroProcesso' => 'required|filled|integer',
            'anoProcesso' => 'required|filled|integer',
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
            DefaultSession::DB_INSTIT + ".required" => mb_convert_encoding(
                "Código da instituicao não informado.", 'UTF-8', 'ISO-8859-1'
            ),DefaultSession::DB_INSTIT + ".filled" => mb_convert_encoding(
                "O código da instituicao informado está vazio.", 'UTF-8', 'ISO-8859-1'
            ),DefaultSession::DB_INSTIT + ".integer" => mb_convert_encoding(
                "Código inválido da instituicao.", 'UTF-8', 'ISO-8859-1'
            ),DefaultSession::DB_CODDEPTO + ".required" => mb_convert_encoding(
                "Código do departamento não informado.", 'UTF-8', 'ISO-8859-1'
            ),DefaultSession::DB_CODDEPTO + ".filled" => mb_convert_encoding(
                "O código do departamento informado está vazio.", 'UTF-8', 'ISO-8859-1'
            ),DefaultSession::DB_CODDEPTO + ".integer" => mb_convert_encoding(
                "Código inválido do departamento.", 'UTF-8', 'ISO-8859-1'
            ),DefaultSession::DB_ID_USUARIO + ".required" => mb_convert_encoding(
                "Código do usuario não informado.", 'UTF-8', 'ISO-8859-1'
            ),DefaultSession::DB_ID_USUARIO + ".filled" => mb_convert_encoding(
                "O código do usuario informado está vazio.", 'UTF-8', 'ISO-8859-1'
            ),DefaultSession::DB_ID_USUARIO + ".integer" => mb_convert_encoding(
                "Código inválido do usuario.", 'UTF-8', 'ISO-8859-1'
            ),
            "numeroProcesso.required" => mb_convert_encoding("Código da Numero de Processo não informado.", 'UTF-8', 'ISO-8859-1'),
            "numeroProcesso.filled" => mb_convert_encoding("O código da Numero de Processo informado está vazio.", 'UTF-8', 'ISO-8859-1'),
            "numeroProcesso.integer" => mb_convert_encoding("Código inválido da Numero de Processo.", 'UTF-8', 'ISO-8859-1'),
            "anoProcesso.required" => mb_convert_encoding("Código do anoProcesso não informado.", 'UTF-8', 'ISO-8859-1'),
            "anoProcesso.filled" => mb_convert_encoding("O código do anoProcesso informado está vazio.", 'UTF-8', 'ISO-8859-1'),
            "anoProcesso.integer" => mb_convert_encoding("Código inválido do anoProcesso.", 'UTF-8', 'ISO-8859-1'),
        ];
    }
}
