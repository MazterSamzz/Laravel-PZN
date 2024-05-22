<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InjectTest extends TestCase
{
    public function testInject(): void
    {
        $this->view('service-injection', ['name' => 'Ivan'])
            ->assertSeeText('Hello Ivan');
    }
}
