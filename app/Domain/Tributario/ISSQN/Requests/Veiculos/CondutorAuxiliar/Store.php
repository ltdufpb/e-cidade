<?php
namespace App\Domain\Tributario\ISSQN\Requests\Veiculos\CondutorAuxiliar;

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
            'q173_cgm'        => 'required|filled|integer',
            'q173_datainicio' => 'required|filled|date',
            'q173_datafim'    => 'nullable|date',
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

            "q173_cgm.required"        => mb_convert_encoding("Cgm não informado.", 'UTF-8', 'ISO-8859-1'),
            "q173_cgm.filled"          => mb_convert_encoding("Cgm informado está vazio.", 'UTF-8', 'ISO-8859-1'),
            "q173_cgm.integer"         => mb_convert_encoding("Cgm inválido.", 'UTF-8', 'ISO-8859-1'),

            "q173_datainicio.required" => mb_convert_encoding("Data de início não informada.", 'UTF-8', 'ISO-8859-1'),
            "q173_datainicio.filled"   => mb_convert_encoding("Data de início vazia.", 'UTF-8', 'ISO-8859-1'),
            "q173_datainicio.date"     => mb_convert_encoding("Data de início inválida.", 'UTF-8', 'ISO-8859-1'),

            "q173_datafim.date"        => mb_convert_encoding("Data de fim inválida.", 'UTF-8', 'ISO-8859-1'),

        ];
    }
}
