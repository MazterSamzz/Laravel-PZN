<?php

namespace Tests\Feature;

use App\Rules\RegistrationRule;
use App\Rules\Uppercase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\In;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ValidatorTest extends TestCase
{
    public function test_Validator(): void
    {
        $data = [
            'username' => 'admin',
            'password' => '123456'
        ];

        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        self::assertNotNull($validator);

        self::assertTrue($validator->passes());
        self::assertFalse($validator->fails());
    }

    public function testValidatorInvalid(): void
    {
        $data = [
            'username' => "",
            'password' => ""
        ];

        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        self::assertNotNull($validator);

        self::assertFalse($validator->passes());
        self::assertTrue($validator->fails());

        $message = $validator->getMessageBag();
        $message->get('username');
        $message->get('password');
        Log::info($message->toJson(JSON_PRETTY_PRINT));
    }

    public function testValidationException(): void
    {
        $data = [
            'username' => '',
            'password' => ''
        ];

        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        self::assertNotNull($validator);

        try {
            $validator->validate();
            self::fail("ValidationException not thrown");
        } catch (ValidationException $exception) {
            self::assertNotNull($exception->validator);
            $message = $exception->validator->errors();
            Log::error($message->toJson(JSON_PRETTY_PRINT));
        }
    }

    public function testValidatorMultipleRules(): void
    {
        App::setLocale('id');

        $data = [
            'username' => "eko",
            'password' => "eko"
        ];

        $rules = [
            'username' => 'required|email|max:100',
            'password' => ['required', 'min:6', 'max:20']
        ];

        $validator = Validator::make($data, $rules);
        self::assertNotNull($validator);

        self::assertFalse($validator->passes());
        self::assertTrue($validator->fails());

        $message = $validator->getMessageBag();
        Log::info($message->toJson(JSON_PRETTY_PRINT));
    }

    public function testValidatorValidData(): void
    {
        $data = [
            'username' => "admin@pzn.com",
            'password' => "rahasia",
            'admin' => true,
            'others' => 'xxx'
        ];
        $rules = [
            'username' => 'required|email|max:100',
            'password' => 'required|min:6|max:20'
        ];

        $validator = Validator::make($data, $rules);
        self::assertNotNull($validator);

        try {
            $valid = $validator->validate();
            Log::info(json_encode($valid, JSON_PRETTY_PRINT));
        } catch (ValidationException $exception) {
            self::assertNotNull($exception->validator);
            $message = $exception->validator->errors();
            Log::error($message->toJson(JSON_PRETTY_PRINT));
        }
    }

    public function testValidatorInlineMessages(): void
    {
        App::setLocale('id');

        $data = [
            'username' => "eko",
            'password' => "eko"
        ];

        $rules = [
            'username' => 'required|email|max:100',
            'password' => ['required', 'min:6', 'max:20']
        ];

        $messages = [
            'required' => ":attribut hatus di isi",
            'email' => ":attribute harus berupa email",
            'min' => ":attribute minimal :min karakter",
            'max' => ":attribute maksimal :max karakter"
        ];

        $validator = Validator::make($data, $rules, $messages);
        self::assertNotNull($validator);

        self::assertFalse($validator->passes());
        self::assertTrue($validator->fails());

        $message = $validator->getMessageBag();
        Log::info($message->toJson(JSON_PRETTY_PRINT));
    }

    public function testValidatorAdditionalValidation(): void
    {
        $data = [
            'username' => "eko@pzn.com",
            'password' => "eko@pzn.com"
        ];

        $rules = [
            'username' => 'required|email|max:100',
            'password' => ['required', 'min:6', 'max:20']
        ];

        $validator = Validator::make($data, $rules);
        $validator->after(function (\Illuminate\Validation\Validator $validator) {
            $data = $validator->getData();
            if ($data['username'] === $data['password']) {
                $validator->errors()->add('password', 'Password tidak boleh sama dengan username');
            }
        });
        self::assertNotNull($validator);

        self::assertFalse($validator->passes());
        self::assertTrue($validator->fails());

        $message = $validator->getMessageBag();
        Log::info($message->toJson(JSON_PRETTY_PRINT));
    }

    public function testValidatorCustomRule(): void
    {
        $data = [
            'username' => "eko@pzn.com",
            'password' => "eko@pzn.com"
        ];

        $rules = [
            'username' => ["required", "email", "max:100", new Uppercase()],
            'password' => ['required', 'min:6', 'max:20', new RegistrationRule()]
        ];

        $validator = Validator::make($data, $rules);
        self::assertNotNull($validator);

        self::assertFalse($validator->passes());
        self::assertTrue($validator->fails());

        $message = $validator->getMessageBag();
        Log::info($message->toJson(JSON_PRETTY_PRINT));
    }

    public function testValidatorCustomFunctionRule(): void
    {
        $data = [
            'username' => "eko@pzn.com",
            'password' => "eko@pzn.com"
        ];

        $rules = [
            'username' => ["required", "email", "max:100", function (string $attribute, string $value, \Closure $fail) {
                if (strtoupper($value) != $value) {
                    $fail("the field $attribute must be UPPERCASE");
                }
            }],
            'password' => ['required', 'min:6', 'max:20', new RegistrationRule()]
        ];

        $validator = Validator::make($data, $rules);
        self::assertNotNull($validator);

        self::assertFalse($validator->passes());
        self::assertTrue($validator->fails());

        $message = $validator->getMessageBag();
        Log::info($message->toJson(JSON_PRETTY_PRINT));
    }

    public function testValidatorRuleClases(): void
    {
        $data = [
            'username' => "eko@pzn.com",
            'password' => "eko@pzn.com"
        ];

        $rules = [
            'username' => ["required", new In(["Eko", "Budi", "Joko"])],
            'password' => ['required', Password::min(6)->letters()->numbers()->symbols()]
        ];

        $validator = Validator::make($data, $rules);
        self::assertNotNull($validator);

        self::assertFalse($validator->passes());
        self::assertTrue($validator->fails());

        $message = $validator->getMessageBag();
        Log::info($message->toJson(JSON_PRETTY_PRINT));
    }
}
