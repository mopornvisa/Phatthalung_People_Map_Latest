<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายการช่วยเหลือ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h2 class="mb-4">รายการช่วยเหลือครัวเรือน</h2>

    <form method="GET" action="{{ route('help_records.index') }}" class="row g-2 mb-4">
        <div class="col-md-4">
            <input
                type="text"
                name="house_id"
                value="{{ $houseId }}"
                class="form-control"
                placeholder="ค้นหาเลขครัวเรือน (HC1 / house_Id)"
            >
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">ค้นหา</button>
        </div>
    </form>

    @if($households->isEmpty())
        <div class="alert alert-warning">ไม่พบข้อมูลครัวเรือน</div>
    @else
        @foreach($households as $h)
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <strong>เลขครัวเรือน:</strong> {{ $h->HC1 }}
                    <br>
                    <strong>ชื่อ:</strong> {{ $h->NAME ?? '-' }} {{ $h->LNAME ?? '' }}
                </div>

                <div class="card-body">
                    @php
                        $records = $helpRecords[$h->HC1] ?? collect();
                    @endphp

                    @if($records->isEmpty())
                        <div class="text-muted">ยังไม่มีข้อมูลการช่วยเหลือ</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>ปีสำรวจ</th>
                                        <th>ปีช่วยเหลือ</th>
                                        <th>วันที่</th>
                                        <th>หน่วยงาน</th>
                                        <th>ประเภท</th>
                                        <th>งบประมาณ</th>
                                        <th>รายละเอียด</th>
                                        <th>สถานะ</th>
                                        <th>ติดตามครั้งถัดไป</th>
                                        <th>ผลลัพธ์</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($records as $r)
                                        <tr>
                                            <td>{{ $r->survey_year ?? '-' }}</td>
                                            <td>{{ $r->help_year ?? '-' }}</td>
                                            <td>{{ $r->action_date ?? '-' }}</td>
                                            <td>{{ $r->agency ?? '-' }}</td>
                                            <td>{{ $r->action_type ?? '-' }}</td>
                                            <td>{{ isset($r->budget) ? number_format($r->budget, 2) : '-' }}</td>
                                            <td>{{ $r->detail ?? '-' }}</td>
                                            <td>{{ $r->status ?? '-' }}</td>
                                            <td>{{ $r->next_followup ?? '-' }}</td>
                                            <td>{{ $r->result ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <a href="{{ route('help_records.create', ['houseId' => $h->HC1, 'survey_year' => request('survey_year')]) }}"
                       class="btn btn-success btn-sm mt-2">
                        เพิ่มข้อมูลช่วยเหลือ
                    </a>
                </div>
            </div>
        @endforeach
    @endif
</div>
</body>
</html>