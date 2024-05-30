<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RawQueryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        DB::delete('delete from categories');
    }
    public function testCrud(): void
    {
        DB::insert('insert into categories (id, name, description, created_at) values (?, ?, ?, ?)', [
            "GADGET", "Gadget", "Gadget Category", "2024-01-01 00:00:00"
        ]);

        $result = DB::select('select * from categories where id = ?', ["GADGET"]);

        self::assertCount(1, $result);
        self::assertEquals('GADGET', $result[0]->id);
        self::assertEquals('Gadget', $result[0]->name);
        self::assertEquals('Gadget Category', $result[0]->description);
        self::assertEquals('2024-01-01 00:00:00', $result[0]->created_at);
    }

    public function testCrudNamedParameter(): void
    {
        DB::insert('insert into categories (id, name, description, created_at) values (:id, :name, :description, :created_at)', [
            "id" => "GADGET",
            "name" => "Gadget",
            "description" => "Gadget Category",
            "created_at" => "2024-01-01 00:00:00"
        ]);

        $result = DB::select('select * from categories where id = ?', ["GADGET"]);

        self::assertCount(1, $result);
        self::assertEquals('GADGET', $result[0]->id);
        self::assertEquals('Gadget', $result[0]->name);
        self::assertEquals('Gadget Category', $result[0]->description);
        self::assertEquals('2024-01-01 00:00:00', $result[0]->created_at);
    }
}