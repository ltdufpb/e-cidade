<?php

namespace App\Domain\Configuracao\Configuracao\Requests;

use App\Http\Requests\DBFormRequest;
use Illuminate\Validation\Rule;

class SalvarOrganogramaRequest extends DBFormRequest
{
    public function rules()
    {
        return [
            'departamento' => ['required', 'integer'],
            'descricao' => ['required', 'string', 'max:100'],
            'departamentofilho' => [
                'required',
                'integer',
                'different:departamento',
                Rule::unique('db_config', 'db21_departamento')
            ],
            'instituicao' => 'integer'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute deve ser informado.',
            'integer' => 'O campo :attribute deve ser do tipo inteiro.',
            'descricao.string' => mb_convert_encoding('A descrição deve ser do tipo string.', 'UTF-8', 'ISO-8859-1'),
            'descricao.max' => mb_convert_encoding('A quantidade máxima caracteres para a descrição é de 100.', 'UTF-8', 'ISO-8859-1'),
            'departamentofilho.different' => mb_convert_encoding('Operação não permitida.', 'UTF-8', 'ISO-8859-1'),
            'departamentofilho.unique' => mb_convert_encoding('Departamento já vinculado à Instituição.', 'UTF-8', 'ISO-8859-1')
        ];
    }
}
