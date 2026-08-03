<?php
namespace App\Domain\Tributario\ISSQN\Requests\Veiculos\Veiculo;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Http\Requests\BaseFormRequest;

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
            'q172_sequencial'    => 'required|filled|integer|exists:issveiculo',
            'q172_datacadastro'  => 'required|filled|date',
            'q172_issbase'       => 'required|filled|integer',
            'q172_tipo'          => 'nullable|integer',
            'q172_marca'         => 'nullable|integer',
            'q172_modelo'        => 'nullable|integer',
            'q172_procedencia'   => 'nullable|integer',
            'q172_categoria'     => 'nullable|integer',
            'q172_chassi'        => 'nullable|string',
            'q172_renavam'       => 'nullable|string',
            'q172_placa'         => 'nullable|string',
            'q172_potencia'      => 'nullable|string',
            'q172_capacidade'    => 'nullable|integer',
            'q172_anofabricacao' => 'nullable|integer',
            'q172_anomodelo'     => 'nullable|integer',
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

            "q172_sequencial.required" => mb_convert_encoding("Sequencial não informado.", 'UTF-8', 'ISO-8859-1'),
            "q172_sequencial.filled"   => mb_convert_encoding("Sequencial informado está vazio.", 'UTF-8', 'ISO-8859-1'),
            "q172_sequencial.integer"  => mb_convert_encoding("Sequencial inválido.", 'UTF-8', 'ISO-8859-1'),
            "q172_sequencial.exists"   => mb_convert_encoding("Nenhum registro para o código informado.", 'UTF-8', 'ISO-8859-1'),

            "q172_datacadastro.required" => mb_convert_encoding("Data de cadastro não informada.", 'UTF-8', 'ISO-8859-1'),
            "q172_datacadastro.filled"   => mb_convert_encoding("Data de cadastro vazia.", 'UTF-8', 'ISO-8859-1'),
            "q172_datacadastro.date"     => mb_convert_encoding("Data de cadastro inválida.", 'UTF-8', 'ISO-8859-1'),

            "q172_issbase.required"        => mb_convert_encoding("Inscrição não informada.", 'UTF-8', 'ISO-8859-1'),
            "q172_issbase.filled"          => mb_convert_encoding("Inscrição informada está vazia.", 'UTF-8', 'ISO-8859-1'),
            "q172_issbase.integer"         => mb_convert_encoding("Inscrição inválida.", 'UTF-8', 'ISO-8859-1'),

            "q172_tipo.integer"          => mb_convert_encoding("Tipo inválido.", 'UTF-8', 'ISO-8859-1'),

            "q172_marca.integer"         => mb_convert_encoding("Marca inválida.", 'UTF-8', 'ISO-8859-1'),

            "q172_modelo.integer"        => mb_convert_encoding("Modelo inválido.", 'UTF-8', 'ISO-8859-1'),

            "q172_procedencia.integer"   => mb_convert_encoding("Procedencia inválida.", 'UTF-8', 'ISO-8859-1'),

            "q172_categoria.integer"     => mb_convert_encoding("Categoria inválida.", 'UTF-8', 'ISO-8859-1'),

            "q172_chassi.string"        => mb_convert_encoding("Chassi inválido.", 'UTF-8', 'ISO-8859-1'),

            "q172_renavam.string"       => mb_convert_encoding("Renavan inválido.", 'UTF-8', 'ISO-8859-1'),

            "q172_placa.string"         => mb_convert_encoding("Placa inválida.", 'UTF-8', 'ISO-8859-1'),

            "q172_potencia.string"      => mb_convert_encoding("Potencia inválida.", 'UTF-8', 'ISO-8859-1'),

            "q172_capacidade.integer"    => mb_convert_encoding("Capacidade inválida.", 'UTF-8', 'ISO-8859-1'),

            "q172_anofabricacao.integer" => mb_convert_encoding("Ano de Fabricação inválido.", 'UTF-8', 'ISO-8859-1'),

            "q172_anomodelo.integer"     => mb_convert_encoding("Ano modelo inválido.", 'UTF-8', 'ISO-8859-1'),


        ];
    }
}
