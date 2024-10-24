<?php

namespace Tests\Feature;

use App\Models\Education;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Laravel\Sanctum\HasApiTokens;
use Tests\TestCase;

class EducationControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Talabani yaratish va autentifikatsiya qilish
        $student = Student::factory()->create();
        Sanctum::actingAs($student);
    }

    public function test_create_education()
    {
        $student = Student::factory()->create();
        $response = $this->postJson('/api/educations', [
            "student_id" => $student->id,
            "name" => "Oliy Ta'lim",
            "description" => "Oliy ta'lim muassasasida o'qish",
            "start_date" => "2022-09-01T00:00:00Z",
            "end_date" => "2024-06-30T00:00:00Z"
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'message' => 'yaratildi',
                'status' => 'success',
            ]);

        $this->assertDatabaseHas('educations', [
            'student_id' => $student->id,
            'name' => "Oliy Ta'lim"
        ]);
    }

    public function test_delete_education()
    {
        $student = Student::factory()->create();
        $education = Education::factory()->create([
            "student_id" => $student->id,
            "name" => "Oliy Ta'lim",
            "description" => "Oliy ta'lim muassasasida o'qish",
            "start_date" => "2022-09-01T00:00:00Z",
            "end_date" => "2024-06-30T00:00:00Z"
        ]);

        $response = $this->deleteJson('/api/educations/' . $education->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('educations', ['id' => $education->id]);
    }

    public function test_index_education()
    {
        $student = Student::factory()->create();
        $education = Education::factory()->create([
            "student_id" => $student->id,
            "name" => "Oliy Ta'lim",
            "description" => "Oliy ta'lim muassasasida o'qish",
            "start_date" => "2022-09-01T00:00:00Z",
            "end_date" => "2024-06-30T00:00:00Z"
        ]);

        $response = $this->getJson('/api/educations');

        $response->assertStatus(200)
            ->assertJson([
                "data" => [
                    [
                        "student_id" => $education->student_id,
                        "name" => $education->name,
                        "description" => $education->description,
                        "start_date" => $education->start_date,
                        "end_date" => $education->end_date
                    ]
                ]
            ]);
    }

    public function test_show_education()
    {
        $student = Student::factory()->create();
        $education = Education::factory()->create([
            "student_id" => $student->id,
            "name" => "Oliy Ta'lim",
            "description" => "Oliy ta'lim muassasasida o'qish",
            "start_date" => "2022-09-01 00:00:00",
            "end_date" => "2024-06-30 00:00:00"
        ]);

        $response = $this->getJson('/api/educations/' . $education->id);

        $response->assertStatus(200)
            ->assertJsonFragment([
                "student_id" => $education->student_id,
                "name" => $education->name,
                "description" => $education->description,
                "start_date" => $education->start_date,
                "end_date" => $education->end_date,
                "id" => $education->id
            ]);
    }
}
