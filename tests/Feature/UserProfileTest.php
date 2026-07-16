<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_profile_name()
    {
        $user = User::factory()->create([
            'nama_lengkap' => 'Old Name',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        $this->actingAs($user);

        $response = $this->post(route('user.profile.update'), [
            'nama_lengkap' => 'New Name',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('status', 'Profil berhasil diperbarui!');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'nama_lengkap' => 'New Name',
        ]);
    }

    public function test_user_with_password_must_provide_correct_current_password_to_change_password()
    {
        $user = User::factory()->create([
            'nama_lengkap' => 'User Name',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        $this->actingAs($user);

        // Try with wrong current password
        $response = $this->post(route('user.profile.update'), [
            'nama_lengkap' => 'User Name',
            'current_password' => 'wrongpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertSessionHasErrors(['current_password']);

        // Try with correct current password
        $response = $this->post(route('user.profile.update'), [
            'nama_lengkap' => 'User Name',
            'current_password' => 'password123',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
    }

    public function test_google_user_without_password_can_set_password_without_current_password()
    {
        $user = User::factory()->create([
            'nama_lengkap' => 'Google User',
            'email' => 'google@gmail.com',
            'password' => null,
            'google_id' => '1234567890',
        ]);

        $this->actingAs($user);

        $response = $this->post(route('user.profile.update'), [
            'nama_lengkap' => 'Google User Changed',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
        $this->assertEquals('Google User Changed', $user->fresh()->nama_lengkap);
    }
}
