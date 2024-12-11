<?php


use App\Models\Contact;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

test('list contacts', function () {
    $contacts = Contact::factory()->count(10)->create();
    $deleted = $contacts->last();
    $deleted->delete();
    $response = get('/');
    $response->assertStatus(200);
    $response->assertViewIs('contact.index');
    $response->assertSeeText($contacts->pluck('email', 'email')->except($deleted->email)->toArray());
});

test('not create contact without data', function () {
    $user = User::factory()->create();
    actingAs($user);
    $response = get('/contact/create');
    $response->assertStatus(200);
    $response->assertViewIs('contact.create');
    $response = post('/contact', []);
    $response->assertSessionHasErrors(['name', 'contact', 'email']);
});
test('validate contact phone digits', function (string $contact, bool $valid) {
    $user = User::factory()->create();
    actingAs($user);
    $response = post('/contact', [
        'name' => fake()->name,
        'contact' => $contact,
        'email' => fake()->email
    ]);
    if ($valid) {
        $response->assertSessionDoesntHaveErrors(['contact']);
    } else {
        $response->assertSessionHasErrors(['contact']);
    }
})->with([
    ['12345678', false],
    ['1234567891', false],
    ['123456789', true],
]);
test('only create contact if phone is unique', function () {
    $user = User::factory()->create();
    actingAs($user);
    $contact = Contact::factory()->create();
    $response = post('/contact', [
        'name' => fake()->name,
        'contact' => $contact->contact,
        'email' => fake()->email
    ]);
    $response->assertSessionHasErrors(['contact']);
});
test('only create contact if email is unique', function () {
    $user = User::factory()->create();
    actingAs($user);
    $contact = Contact::factory()->create();
    $response = post('/contact', [
        'name' => fake()->name,
        'contact' => fake()->phoneNumber,
        'email' => $contact->email
    ]);
    $response->assertSessionHasErrors(['email']);
});
test('create contact', function () {
    $user = User::factory()->create();
    actingAs($user);
    $response = post('/contact', [
        'name' => fake()->name,
        'contact' => '123456789',
        'email' => fake()->email
    ]);
    $response->assertRedirect('/');
    expect(Contact::count())->toBe(1);
});
test('update contact', function () {
    $user = User::factory()->create();
    actingAs($user);
    $contact = Contact::factory()->create();
    $response = put("/contact/{$contact->id}", [
        'name' => fake()->name,
        'contact' => '123456789',
        'email' => fake()->email
    ]);
    $response->assertRedirectToRoute('home');
});
test('only update contact if phone is unique', function () {
    $user = User::factory()->create();
    actingAs($user);
    $contact = Contact::factory()->create();
    $contact2 = Contact::factory()->create();
    $response = put("/contact/{$contact->id}", [
        'name' => fake()->name,
        'contact' => $contact2->contact,
        'email' => fake()->email
    ]);
    $response->assertSessionHasErrors(['contact']);
});
test('only update contact if email is unique', function () {
    $user = User::factory()->create();
    actingAs($user);
    $contact = Contact::factory()->create();
    $contact2 = Contact::factory()->create();
    $response = put("/contact/{$contact->id}", [
        'name' => fake()->name,
        'contact' => fake()->phoneNumber,
        'email' => $contact2->email
    ]);
    $response->assertSessionHasErrors(['email']);
});
test('delete contact', function () {
    $user = User::factory()->create();
    actingAs($user);
    $contact = Contact::factory()->create();
    $response = delete("/contact/{$contact->id}");
    $response->assertStatus(204);
    expect(Contact::count())->toBe(0)
        ->and(Contact::withTrashed()->count())->toBe(1);
});
test('contact polices for guest user', function () {
    $contact = Contact::factory()->create();
    $response = get("/");
    $response->assertStatus(200);
    $response = get(route('contact.show', $contact));
    $response->assertStatus(403);
    $response = get(route('contact.edit', $contact));
    $response->assertStatus(403);
    $response = put(route('contact.update', $contact), []);
    $response->assertStatus(403);
    $response = delete(route('contact.destroy', $contact));
    $response->assertStatus(403);
});
test('contact polices for authenticated user', function () {
    $user = User::factory()->create();
    actingAs($user);
    $contact = Contact::factory()->create();
    $response = get("/");
    $response->assertStatus(200);
    $response = get(route('contact.show', $contact));
    $response->assertStatus(200);
    $response = get(route('contact.edit', $contact));
    $response->assertStatus(200);
    $response = put(route('contact.update', $contact), []);
    $response->assertStatus(302);
    $response = delete(route('contact.destroy', $contact));
    $response->assertStatus(204);
});
