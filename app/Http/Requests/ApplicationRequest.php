<?php

namespace App\Http\Requests;

use App\Exceptions\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ApplicationRequest extends FormRequest
{
    public function failedValidation(Validator $validator)
    {
        /**
         * Illuminate\Contracts\Validation\Validator does not have getRules() function
         * but $validator is actually an instance of Illuminate\Validation\Validator
         * which has getRules()
         */
        $allRules = $validator->getRules();
        $errorMessages = $validator->errors()->getMessages();
        $failedRules = $validator->failed();

        $allErrors = [];
        foreach ($failedRules as $fieldName => $fieldRules) {
            $i = 0;
            $fieldErrors = [];
            foreach ($fieldRules as $rule => $ruleInfo) {
                $errorObject = [];
                $errorObject['type'] = Str::snake($rule);
                $errorObject['description'] = $errorMessages[$fieldName][$i];

                $customizeRuleInfo = $this->getCustomizeRuleInfo(Str::snake($rule), $ruleInfo);
                $errorObject = array_merge($errorObject, $customizeRuleInfo);

                $fieldErrors [] = $errorObject;
                $i++;
            }
            $allErrors[$fieldName] = $fieldErrors;
        }

        throw new ValidationException($allErrors);
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }

    private function getCustomizeRuleInfo(string $ruleName, array $ruleInfo)
    {
        switch ($ruleName) {
            case 'max':
                return ['limit' => $ruleInfo[0]];
            case 'min':
                return ['limit' => $ruleInfo[0]];
            case 'file':
                return ['limit' => $ruleInfo[0]];
            case 'greater_than':
                return ['limit' => $ruleInfo[0]];
            case 'digits':
                return ['limit' => $ruleInfo[0]];
            case 'digits_between':
                return [
                    'min' => $ruleInfo[0],
                    'max' => $ruleInfo[1]
                ];
            case 'between':
                return [
                    'min' => $ruleInfo[0],
                    'max' => $ruleInfo[1]
                ];
            case 'mimes':
                return ['mimes_types' => $ruleInfo];
            case 'digits':
                return ['length' => $ruleInfo[0]];
            case 'required_without':
                return ['fields' => $ruleInfo];
            case 'required_without_all':
                return ['fields' => $ruleInfo];
            default:
                return [];
        }
    }
}
