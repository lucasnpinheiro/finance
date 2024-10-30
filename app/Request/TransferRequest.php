<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class TransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'account_number_origin' => 'required',
            'account_number_destination' => 'required',
            'transaction_value' => 'required',
        ];
    }

    public function accountNumberOrigin(): string
    {
        return $this->input('account_number_origin');
    }

    public function accountNumberDestination(): string
    {
        return $this->input('account_number_destination');
    }

    public function transactionValue(): float
    {
        return (float)$this->input('transaction_value');
    }
}
