@extends('admin.backend.layouts.index')
@section('content')
    @push('styles')
        <style>
            td{
                font-size: 17px;
                font-weight: 600;
            }
        </style>
    @endpush
    <table class="table" style="table-layout: fixed; ">
        <thead>
            <th>S.N.</th>
            <th>Year</th>
            <th>Month</th>
            <th>Holidays</th>
        </thead>
        <tbody class="report-data">
            @foreach ($public_holidays as $public_holiday)
                <tr>
                    <td style="vertical-align: middle;">
                        {{ $loop->iteration }}
                    </td>
                    <td style="vertical-align: middle;"> {{ $public_holiday->year }}</td>
                    <td style="vertical-align: middle;"> {{ ucfirst($public_holiday->month) }}</td>
                    <td style="width: 100%; vertical-align: middle; font-size: 15px; font-weight: 500;">

                        <div style="display: flex; flex-wrap: wrap;">
                            @if (count(json_decode($public_holiday->public_holidays_bs)))
                                @foreach (json_decode($public_holiday->public_holidays_bs) as $holiday)
                                    <span
                                        style="display: inline-block; background: rgb(241, 164, 164); padding: 10px 15px; border-radius: 5px; margin: 5px;">{{ explode(',', $holiday[0])[0] }}</span>
                                @endforeach
                            @endif
                        </div>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
