<table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;">
    <thead style="background-color: #4CAF50; color: white; font-weight: bold;">
        <tr>
            <th style="padding: 10px; text-align: left; background-color: #4CAF50;">ID</th>
            <th style="padding: 10px; text-align: left;background-color: #4CAF50;">Name</th>
            <th style="padding: 10px; text-align: left;background-color: #4CAF50;">Email</th>
            <th style="padding: 10px; text-align: left;background-color: #4CAF50;">Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr style="border-bottom: 1px solid #ddd;">
                <td style="padding: 8px;">{{ $user->id }}</td>
                <td style="padding: 8px;">{{ $user->name }}</td>
                <td style="padding: 8px;">{{ $user->email }}</td>
                <td style="padding: 8px;">{{ $user->created_at->format('Y-m-d') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<style>
    /* Thêm các kiểu CSS để làm bảng đẹp hơn */
    table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    thead {
        background-color: #4CAF50;
        color: white;
        font-weight: bold;
    }

    th, td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2; /* Chế độ zebra row */
    }

    tr:hover {
        background-color: #ddd; /* Hiệu ứng hover cho mỗi dòng */
    }

    th {
        background-color: #4CAF50;
        color: white;
    }

    td {
        background-color: #fafafa;
    }

    /* Tùy chỉnh font chữ */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
    }
</style>
