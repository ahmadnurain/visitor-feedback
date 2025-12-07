<?php

namespace Tests\Feature;

use App\Models\Destination;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FeedbackSubmitTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_submit_feedback(): void
    {
        Storage::fake('public');
        $dest = Destination::factory()->create(['is_active' => true]);
        $cat = \App\Models\FeedbackCategory::create([
            'name' => 'Apresiasi',
            'slug' => 'apresiasi',
            'is_active' => true
        ]);

        $res = $this->post('/feedbacks', [
            'destination_id' => $dest->id,
            'feedback_category_id' => $cat->id,
            'rating' => 5,
            'title' => 'Mantap',
            'content' => 'Sangat bagus',
            'attachments' => [UploadedFile::fake()->image('a.jpg')],
        ]);

        $res->assertRedirect(route('thanks'));
    }
}
