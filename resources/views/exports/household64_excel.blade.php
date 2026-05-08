{{-- HEADER TABLE --}}
<tr>
    <th style="background:#dff7ef;border:1px solid #8dd8c7;padding:8px;text-align:center;font-weight:bold;width:60px;">
        ลำดับ
    </th>

    <th style="background:#dff7ef;border:1px solid #8dd8c7;padding:8px;text-align:center;font-weight:bold;">
        เลขครัวเรือน
    </th>

    <th style="background:#dff7ef;border:1px solid #8dd8c7;padding:8px;text-align:center;font-weight:bold;width:90px;">
        ปีที่สำรวจ
    </th>

    <th style="background:#dff7ef;border:1px solid #8dd8c7;padding:8px;text-align:center;font-weight:bold;width:100px;">
        ครั้งที่สำรวจ
    </th>

    <th style="background:#dff7ef;border:1px solid #8dd8c7;padding:8px;text-align:center;font-weight:bold;width:100px;">
        สมุดเกษตร
    </th>

    <th style="background:#dff7ef;border:1px solid #8dd8c7;padding:8px;text-align:center;font-weight:bold;">
        เลขเกษตร
    </th>

    <th style="background:#dff7ef;border:1px solid #8dd8c7;padding:8px;text-align:center;font-weight:bold;width:90px;">
        บ้านเลขที่
    </th>

    <th style="background:#dff7ef;border:1px solid #8dd8c7;padding:8px;text-align:center;font-weight:bold;width:80px;">
        หมู่ที่
    </th>

    <th style="background:#dff7ef;border:1px solid #8dd8c7;padding:8px;text-align:center;font-weight:bold;">
        หมู่บ้าน
    </th>

    <th style="background:#dff7ef;border:1px solid #8dd8c7;padding:8px;text-align:center;font-weight:bold;">
        ตำบล
    </th>

    <th style="background:#dff7ef;border:1px solid #8dd8c7;padding:8px;text-align:center;font-weight:bold;">
        อำเภอ
    </th>

    <th style="background:#dff7ef;border:1px solid #8dd8c7;padding:8px;text-align:center;font-weight:bold;">
        จังหวัด
    </th>

    <th style="background:#dff7ef;border:1px solid #8dd8c7;padding:8px;text-align:center;font-weight:bold;width:100px;">
        รหัสไปรษณีย์
    </th>

    <th style="background:#dff7ef;border:1px solid #8dd8c7;padding:8px;text-align:center;font-weight:bold;width:130px;">
        เบอร์โทรศัพท์
    </th>
</tr>

<tbody>

@forelse($rows as $index => $r)

@php
    $bg = $index % 2 == 0 ? '#ffffff' : '#f8fffd';

    $agri = trim((string)($r->AGRI ?? ''));

    $agriLabel = in_array(strtolower($agri), ['1','y','yes','true','มี'])
        ? 'มี'
        : 'ไม่มี';
@endphp

<tr>

    <td style="border:1px solid #d6eee8;padding:6px;text-align:center;background:{{ $bg }};">
        {{ $index + 1 }}
    </td>

    <td style="border:1px solid #d6eee8;padding:6px;background:{{ $bg }};font-weight:bold;">
        {{ $r->HC ?? '-' }}
    </td>

    <td style="border:1px solid #d6eee8;padding:6px;text-align:center;background:{{ $bg }};">
        {{ $r->survey_year ?? '-' }}
    </td>

    <td style="border:1px solid #d6eee8;padding:6px;text-align:center;background:{{ $bg }};">
        {{ $r->survey_no ?? '-' }}
    </td>

    <td style="border:1px solid #d6eee8;padding:6px;text-align:center;background:{{ $bg }};">
        {{ $agriLabel }}
    </td>

    <td style="border:1px solid #d6eee8;padding:6px;background:{{ $bg }};">
        {{ $r->AGRI_NO ?? '-' }}
    </td>

    <td style="border:1px solid #d6eee8;padding:6px;text-align:center;background:{{ $bg }};">
        {{ $r->MBNO ?? '-' }}
    </td>

    <td style="border:1px solid #d6eee8;padding:6px;text-align:center;background:{{ $bg }};">
        {{ $r->MB ?? '-' }}
    </td>

    <td style="border:1px solid #d6eee8;padding:6px;background:{{ $bg }};">
        {{ $r->MM ?? '-' }}
    </td>

    <td style="border:1px solid #d6eee8;padding:6px;background:{{ $bg }};">
        {{ $r->tambon_name_thai ?? $r->TMP ?? '-' }}
    </td>

    <td style="border:1px solid #d6eee8;padding:6px;background:{{ $bg }};">
        {{ $r->district_name_thai ?? $r->AMP ?? '-' }}
    </td>

    <td style="border:1px solid #d6eee8;padding:6px;background:{{ $bg }};">
        {{ $r->province_name_thai ?? $r->JUN ?? '-' }}
    </td>

    <td style="border:1px solid #d6eee8;padding:6px;text-align:center;background:{{ $bg }};">
        {{ $r->POSTCODE ?? '-' }}
    </td>

    <td style="border:1px solid #d6eee8;padding:6px;background:{{ $bg }};">
        {{ $r->TEL ?? '-' }}
    </td>

</tr>

@empty

<tr>
    <td colspan="14"
        style="
            padding:14px;
            text-align:center;
            color:#64748b;
            background:#f8fafc;
            border:1px solid #dbe7f3;
        ">
        ไม่พบข้อมูล
    </td>
</tr>

@endforelse

</tbody>