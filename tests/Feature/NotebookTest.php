<?php

namespace Tests\Feature;

use App\Models\Notebook;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class NotebookTest extends TestCase
{
    use RefreshDatabase;

    public static function createProvider():array
    {
        return [
            ['Test', 'TestCo', '+79999999999', 'test@gmail.com', '01.01.1999', 'http://test.com/photo.jpg', 200],
            ['123', '123', 'sdcsdvsdvsds', 'test@gmail.com2', '01.01.1999', 'http://test.com/photo.jpg',422]
        ];
        }

    public static function showProvider():array
    {
        return [
            ['Test', 'TestCo', '+79999999999', 'test@gmail.com', '01.01.1999', 'http://test.com/photo.jpg',1 ,200],
            ['Test2', 'TestCo2', '+79999999998', 'test2@gmail.com', '01.01.1998','http://test.com/photo.jpg',5,404]
        ];
    }

    public static function updateProvider():array
    {
        return [
            ['Test', 'TestCo', '+79999999999', 'test@gmail.com', '01.01.1999', 'http://test.com/photo.jpg',1 ,200, 'Vasya'],
            ['Test2', 'TestCo2', '+79999999998', 'test2@gmail.com', '01.01.1998','http://test.com/photo.jpg',9,404, 'Petya']
        ];
    }

    public static function deleteProvider():array
    {
        return [
            ['Test', 'TestCo', '+79999999999', 'test@gmail.com', '01.01.1999', 'http://test.com/photo.jpg',1 ,200],
            ['Test2', 'TestCo2', '+79999999998', 'test2@gmail.com', '01.01.1998','http://test.com/photo.jpg',5,404]
        ];
    }


    #[DataProvider('createProvider')]
    public function testCreateNotebook(
        string $name, string $nameCo, string $phone, string $email, string $date, string $link, int $resp
    )
    {
        $response = $this->postJson('api/v1/notebook', [
            'full_name' => $name,
            'company_name' => $nameCo,
            'phone' => $phone,
            'email' =>$email,
            'birthday' => $date,
            'photo_url' => $link,
        ]);

        $response->assertStatus($resp);
    }

    #[DataProvider('showProvider')]
    public function testShowNotebook(
        string $name, string $nameCo, string $phone, string $email, string $date, string $link,int $id, int $resp
    )
    {
            $this->postJson('api/v1/notebook', [
            'full_name' => $name,
            'company_name' => $nameCo,
            'phone' => $phone,
            'email' =>$email,
            'birthday' => $date,
            'photo_url' => $link,
        ]);

        $response = $this->get("api/v1/notebook/{$id}");

        $response->assertStatus($resp);

    }

    #[DataProvider('updateProvider')]
    public function testUpdateNotebook(
        string $name, string $nameCo, string $phone, string $email, string $date, string $link,int $id, int $resp, string $newName
    )
    {
        $this->postJson('api/v1/notebook', [
            'full_name' => $name,
            'company_name' => $nameCo,
            'phone' => $phone,
            'email' =>$email,
            'birthday' => $date,
            'photo_url' => $link,
        ]);

        $response = $this->putJson("api/v1/notebook/{$id}", [
            'full_name' => $newName,
        ]);

        $response->assertStatus($resp);
    }

    #[DataProvider('deleteProvider')]
    public function testDeleteNotebook(
        string $name, string $nameCo, string $phone, string $email, string $date, string $link,int $id, int $resp
    )
    {
        $this->postJson('api/v1/notebook', [
            'full_name' => $name,
            'company_name' => $nameCo,
            'phone' => $phone,
            'email' =>$email,
            'birthday' => $date,
            'photo_url' => $link,
        ]);


        $response = $this->delete("api/v1/notebook/{$id}");

        $response->assertStatus($resp);
    }
}
