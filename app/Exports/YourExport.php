<?php

namespace App\Exports;

use App\Models\Post;
use App\Models\User;
use App\Models\YourModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromGenerator;
use Maatwebsite\Excel\Concerns\WithHeadings;

class YourExport implements FromGenerator, WithHeadings
{
    // protected $posts;
    // public function __construct($posts){
    //     $this->posts = $posts;
    // }
    // Phương thức trả về dữ liệu dưới dạng Generator
    public function generator(): \Generator
    {
        // foreach ($this->posts as $post) {
        //     // Dùng yield để trả về dữ liệu từng bản ghi
        //     yield [$post->id, $post->title, $post->content];
        // }

        // $posts = Post::select('id','title','content')->cursor();
        // foreach ($this->posts as $post) {
        //     // Yield từng bản ghi ra, giúp giảm thiểu bộ nhớ
        //     yield [
        //         $post->id,
        //         $post->title,
        //         $post->content,
        //     ];
        // }
        foreach (Post::cursor() as $post) {
            yield [
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
            ];
        }


        // $loopCount = 120;
        // // $loopCount = floor(Post::count()/1000);
        // $offset = 0;
        // for($i=0;$i<$loopCount;$i++){
        //     $posts = Post::skip($offset)->take(1000)->get();
        //     dump($posts);
        //     dump($i);
        //     foreach ($posts as $post) {
        //         yield [
        //             $post->id,
        //             $post->title,
        //             $post->content,
        //         ];
        //     }
        //     $offset+=1000;
        // }

    }

    // Phương thức để định nghĩa các tiêu đề cột trong file Excel
    public function headings(): array
    {
        return ['ID', 'Name', 'Email'];
    }
}

