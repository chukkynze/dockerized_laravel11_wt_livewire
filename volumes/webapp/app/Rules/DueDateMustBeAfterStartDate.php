<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use JetBrains\PhpStorm\NoReturn;

class DueDateMustBeAfterStartDate implements DataAwareRule, ValidationRule
{
    /**
     * All the data under validation.
     *
     * @var array<string, mixed>
     */
    protected array $data = [];

    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    #[NoReturn] public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $startDt = Carbon::parse($this->data['start_dt']);
        $dueByDt = Carbon::parse($this->data['due_by_dt']);

        if ($startDt->greaterThanOrEqualTo($dueByDt)) {
            $fail('The due date must come after the start date.');
        }
    }
}
