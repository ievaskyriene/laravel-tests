<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;

class BookManagmentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function book_can_be_added()
    {
        //given
        $this->withoutExceptionHandling();
        $bookData = [
            'isbn' => 9780840700551,
            'title' => 'Holy Bible'
        ];

        //when

        //then
        $response = $this->post(
            '/books',
            $bookData
        );
        $response->assertStatus(200);
        $this->assertCount(1, Book::all());
    }

    /** @test */
    public function title_is_required_to_create_book1()
    {
        // given
        $this->withoutExceptionHandling();
        $bookData = ['isbn' => 9780840700551, 'title' => ''];
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $this->expectExceptionMessage('The given data was invalid.');
        // when
        $response = $this->post('/books', $bookData);
        // then
        $response->assertStatus(200);
        $this->assertCount(1, Book::all());
    }

    /** @test */
    public function title_is_required_to_create_book()
    {
        // given
        $bookData = ['isbn' => 9780840700551, 'title' => ''];
        // when
        $response = $this->post('/books', $bookData);
        // then
        $response->assertStatus(302);
        $response->assertSessionHasErrors('title');
        //patikriname ar neissisaugojo nevalidus modelis
        $this->assertCount(0, Book::all());
    }

    /** @test */
    public function book_can_be_updated()
    {
        // given
        $this->withoutExceptionHandling();
        $bookData = ['isbn' => 9780840700551, 'title' => 'Holy Bible'];
        $this->post('/books', $bookData);

        // when
        $updatedBookData = ['isbn' => 9780840700551, 'title' => 'Anything'];
        $response = $this->put('/books/' . $updatedBookData['isbn'], $updatedBookData);

        // then
        $response->assertStatus(200);
        $this->assertCount(1, Book::all());
        $this->assertEquals($updatedBookData['isbn'], Book::first()->isbn);
        $this->assertEquals($updatedBookData['title'], Book::first()->title);
    }
}
