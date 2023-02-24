<?php

namespace Tests\Unit\app\Http\Controllers\API;

use PHPUnit\Framework\TestCase;
use App\Repository\{AuthorsRepository,BooksRepository,LibraryRepository};
use App\Http\Resources\{GeneralResponse,GeneralError};
use App\Http\Controllers\API\BooksAPIController;
use Illuminate\Http\JsonResponse;
use Mockery;
use Exception;

class BooksAPIControllerTest extends TestCase
{
    public $bookRepo, $authorRepo, $libraryRepo, $generalError;
    public function setUp(): void
    {
        parent::setUp();
        $this->bookRepo = $this->mock(BooksRepository::class);
        $this->authorRepo = $this->mock(AuthorsRepository::class);
        $this->libraryRepo = $this->mock(LibraryRepository::class);
        $this->generalError = $this->mock(GeneralError::class);
    }

    public function mock($class)
    {
        return Mockery::mock($class);
    }

    public function test_index_success()
    {
        $returnData = collect();

        $this->bookRepo->shouldReceive('getBooks')
        ->once()
        ->andReturn($returnData);

        $controller = new BooksAPIController(
            $this->bookRepo,
            $this->authorRepo,
            $this->libraryRepo,
        );

        $response = $controller->index();

        $this->assertInstanceOf(GeneralResponse::class ,$response);
    }

    public function test_index_error()
    {
        $this->bookRepo->shouldReceive('getBooks')
        ->once()
        ->andThrow(new Exception());

        $controller = new BooksAPIController(
            $this->bookRepo,
            $this->authorRepo,
            $this->libraryRepo,
        );

        $this->generalError
            ->shouldReceive('make')
            ->with([
                'message' => '',
                'error' => []
            ])
            ->andReturn(JsonResponse::class);

        $response = $controller->index();

        $this->assertInstanceOf(JsonResponse::class ,$response);
    }

    public function test_destroy_success()
    {
        $returnData = 1;

        $this->bookRepo->shouldReceive('delete')
        ->once()
        ->andReturn($returnData);

        $controller = new BooksAPIController(
            $this->bookRepo,
            $this->authorRepo,
            $this->libraryRepo,
        );

        $response = $controller->destroy(1);

        $this->assertInstanceOf(GeneralResponse::class ,$response);
    }

    public function test_destroy_error()
    {
        $this->bookRepo->shouldReceive('delete')
        ->once()
        ->andThrow(new Exception());

        $controller = new BooksAPIController(
            $this->bookRepo,
            $this->authorRepo,
            $this->libraryRepo,
        );

        $this->generalError
            ->shouldReceive('make')
            ->with([
                'message' => '',
                'error' => []
            ])
            ->andReturn(JsonResponse::class);

        $response = $controller->destroy(1);

        $this->assertInstanceOf(JsonResponse::class ,$response);
    }

    public function test_fetch_author_library_success()
    {
        $returnData = collect();

        $this->authorRepo->shouldReceive('get')
        ->once()
        ->andReturn($returnData);
        $this->libraryRepo->shouldReceive('get')
        ->once()
        ->andReturn($returnData);

        $controller = new BooksAPIController(
            $this->bookRepo,
            $this->authorRepo,
            $this->libraryRepo,
        );

        $response = $controller->getAuthorsLibrariesData(1);

        $this->assertInstanceOf(GeneralResponse::class ,$response);
    }
}
