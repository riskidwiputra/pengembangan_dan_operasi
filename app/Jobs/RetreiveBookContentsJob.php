<?php

namespace App\Jobs;

use App\Models\Book;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class RetreiveBookContentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $books;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Book $book) {
        $this->books = $book;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $url        =  env('URL_BOOK', 'https://rak-buku-api.vercel.app/api/books/');
        $isbn       =  $this->books->isbn;
        $id_book    =  $this->books->id;
        $getData    =  Http::get($url.$isbn);
        if(!isset($getData['errors'])){
            if(!empty($getData['data']) || $getData['data'] != ''){
                $table_content =  $getData['data']['details']['table_of_contents'];
                $data = array();
                foreach($table_content as $book)
                {
                    if(!empty($book))
                    {
                        $data[] =[
                            'book_id'       => $id_book,
                            'label'         => $book['label'],
                            'title'         => $book['title'],
                            'page_number'   => $book['pagenum']
                        ];                 
                    }
                }
                $this->books->bookContents()->insert($data);
            }else{
                $this->books->bookContents()->create([
                    'label'         => null,
                    'title'         => "Cover",
                    'page_number'   => 1
                ]);
            }
        }
    }
}
