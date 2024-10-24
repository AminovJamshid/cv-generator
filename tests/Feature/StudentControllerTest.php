<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StudentControllerTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_create_a_student(): void
    {
        $response = $this->postJson('/api/students', [
            "first_name" => "John",
            "last_name" => "Doe",
            "nt_id" => "77777",
            "photo" => "aidak12.jpg",
            "profession" => "student",
            "phone" => "998977777777",
            "biography" => "Talk is cheap, show me the code"
        ]);

        $response->assertStatus(201)
            ->assertJson([
                "first_name" => "John",
                "last_name" => "Doe",
                "nt_id" => "77777",
                "profession" => "student",
            ]);
    }

//    public function test_create_a_student_validation_error_on_missing_fields(): void
//    {
//        $response = $this->postJson('/api/students', [
//            "first_name" => "John",
//            "last_name" => "Doe",
//            "nt_id" => "77777",
//            "photo" => "skjnndsk1234.jpg",
//            "profession" => "student",
//            "phone" => "998888888888",
//            "biography" => "If it ain't broke, don't fix it."
//
//        ]);
//
//        $response->assertStatus(422);
//    }

//    public function test_update_a_student()
//    {
//        $student = Student::factory()->create();
//
//        $response = $this->putJson("/api/students/2", [
//            "first_name" => $student->first_name,
//            "last_name" => $student->last_name,
//            "nt_id" => $student->nt_id,
//            "photo" => $student->photo,
//            "profession" => $student->profession,
//            "phone" => $student->phone,
//            "biography" => $student->biography
//        ]);
//
//        $response->assertStatus(201)
//            ->assertJson([
//                "first_name" => $student->first_name,
//                "last_name" => $student->last_name,
//                "nt_id" => $student->nt_id,
//                "profession" => $student->profession,
//            ]);
//    }


    public function test_update_a_validation_failed()
    {
        $student = Student::factory()->create();

        $response = $this->putJson('/api/students/' . $student->id, [
            "first_name" => "",
            "last_name" => $student->last_name,
            "nt_id" => $student->nt_id,
            "photo" => $student->photo,
            "profession" => $student->profession,
            "phone" => $student->phone,
            "biography" => $student->biography
        ]);

        $response->assertStatus(422)
        ->assertJsonStructure([
            "message",
            "errors" => [
                "first_name",
            ],
        ])
            ->assertJson([
                "errors" => [
                    "first_name" => ["The first name field is required."],
                ],
            ]);
    }

    public  function  test_destroy_a_student()
    {
        $student = Student::factory()->create();

        $response = $this ->deleteJson('/api/students/' . $student->id);

        $response->assertStatus(204);
    }


    public  function  test_show_a_student()
    {
        $student = Student::factory()->create();

        $response = $this ->getJson('/api/students/' . $student->id);

        $response->assertStatus(201)
        ->assertJson([
            "first_name" => $student->first_name,
            "last_name" => $student->last_name,
            "nt_id" => $student->nt_id,
            "profession" => $student->profession,
        ]);

    }

}
