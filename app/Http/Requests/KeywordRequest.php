<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class KeywordRequest extends FormRequest
{
    /** @var string */
    protected $redirectRoute = 'keyword.form';

    public function authorize(): bool
    {
        return true;
    }

    #[\JetBrains\PhpStorm\ArrayShape(
        [
            'keyword' => "string"
        ]
    )]
    public function rules(): array
    {
        return [
            'word' => 'required|max:255'
        ];
    }
}
