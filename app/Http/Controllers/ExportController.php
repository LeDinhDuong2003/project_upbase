<?php

namespace App\Http\Controllers;

use App\Exports\ExportUserFromView;
use App\Exports\YourExport;
use App\Factories\PostExportFactory;
use App\Factories\UserExportFactory;
use App\Jobs\ExportExcelJob;
use App\Jobs\ExportPostJob;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Jobs\AppendDataToSheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Rap2hpoutre\FastExcel\FastExcel;

class ExportController extends Controller
{
    public function exportUser()
    {
        $factory = new UserExportFactory();
        $export = $factory->createExportExcel();
        $export->export();
        return response()->json("message");
    }
    public function exportPost()
    {
        // phpinfor();
        // $factory = new PostExportFactory();
        // $export = $factory->createExportExcel();
        // return $export->export();

        // Tạo tên file Excel
        $fileName = 'posts_' . time() . '.xlsx';

        // Gửi công việc vào queue
        ExportPostJob::dispatch($fileName);

        return response()->json(['message' => 'Export job has been queued.']);
    }
    public function exportUserfromView()
    {
        $users = User::all(); // Lấy dữ liệu từ Model
        // return Excel::download(new ExportUserFromView($users), 'users.xlsx');
        return Excel::store(new ExportUserFromView($users), 'exceluser.xlsx', 'public');
    }
    public function exportExcel()
    {
        // Đặt tên file cho file Excel xuất ra
        // $fileName = 'exported_data.xlsx';

        // // Đẩy Job vào Queue
        // ExportExcelJob::dispatch($fileName);


        // $count = 1;
        // Post::query()->chunk(1000, function ($posts) use (&$count) {
        //     dump($posts);
        //     Excel::store(new YourExport($posts), 'posts/post' . $count . '.xlsx', 'public', \Maatwebsite\Excel\Excel::XLSX);
        //     $count++;
        // });
        // // dd(Post::count());
        Excel::store(new YourExport(), 'posts.xlsx','public');


        // function usersGenerator()
        // {
        //     // Lấy dữ liệu bằng cursor để tránh việc tải tất cả vào bộ nhớ
        //     foreach (Post::orderBy('id')->cursor() as $post) {
        //         // Đảm bảo dữ liệu được trả về dưới dạng mảng cho FastExcel
        //         yield [
        //             'id' => $post->id,
        //             'title' => $post->title,
        //             'content' => $post->content,
        //         ];
        //     }
        // }
        
        // // Export dữ liệu lớn mà không tải hết vào bộ nhớ
        // (new FastExcel(usersGenerator()))->export('test.xlsx');



        return response()->json(['message' => 'Export started!']);
    }
    public function appendDataToExcel($filePath, $newData)
    {
        // Mở file Excel hiện có
        $spreadsheet = IOFactory::load($filePath);

        // Lấy sheet đầu tiên (hoặc chọn sheet cần append)
        $sheet = $spreadsheet->getActiveSheet();

        // Tìm số dòng cuối cùng đã có dữ liệu
        $highestRow = $sheet->getHighestRow(); // Lấy số dòng cuối cùng có dữ liệu

        // Append dữ liệu mới vào cuối
        foreach ($newData as $row) {
            $highestRow++; // Tăng số dòng lên
            $sheet->fromArray($row->toArray(), NULL, 'A' . $highestRow); // Thêm dòng mới vào
        }

        // Lưu lại file Excel sau khi append
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($filePath);
    }
}
