<?php

namespace App\Providers;

use App\Modules\Authors\Interfaces\AuthorsRepositoryInterface;
use App\Modules\Authors\Repositories\AuthorsRepository;
use App\Modules\Books\Interfaces\BooksRepositoryInterface;
use App\Modules\Books\Interfaces\BooksServiceInterface;
use App\Modules\Books\Repositories\BooksRepository;
use App\Modules\Books\Services\BooksService;
use App\Modules\Reviews\Services\ReviewsService;
use App\Modules\Reviews\Repositories\ReviewsRepository;
use App\Modules\Reviews\Interfaces\ReviewsRepositoryInterface;
use App\Modules\Reviews\Interfaces\ReviewsServiceInterface;
use App\Modules\Users\Interfaces\UsersRepositoryInterface;
use App\Modules\users\Repositories\UsersRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BooksRepositoryInterface::class,BooksRepository::class);
        $this->app->bind(BooksServiceInterface::class,BooksService::class);
        $this->app->bind(ReviewsRepositoryInterface::class,ReviewsRepository::class);
        $this->app->bind(ReviewsServiceInterface::class,ReviewsService::class);
        $this->app->bind(AuthorsRepositoryInterface::class,AuthorsRepository::class);
        $this->app->bind(UsersRepositoryInterface::class,UsersRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Collection::macro('paginate', function ($perPage = 15, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
 
            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path'     => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
    }
}
