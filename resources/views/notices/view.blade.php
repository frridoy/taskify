{{-- @extends('setup.master')
@section('content')
<div class="container">
    <div class="official-notice">
        <!-- Letterhead/Header -->
        <div class="notice-header text-center mb-4">
            <div class="organization-logo mb-2">
                <!-- Replace with your logo or organization name -->
                <h2 class="mb-0">{{$organization_info->company_name}}</h2>
            </div>
            <div class="organization-address">
                <p class="mb-0">{{$organization_info->company_location}}</p>
                <p class="mb-0">{{$organization_info->company_phone}} | {{$organization_info->company_email}}</p>
            </div>
        </div>

        <!-- Reference and Date -->
        <div class="notice-meta d-flex justify-content-between mb-4">
            <div class="ref-no">
                <strong>Ref:</strong> {{ $notice->reference_no ?? 'N/A' }}
            </div>
            <div class="notice-date">
                <strong>Date:</strong> {{ \Carbon\Carbon::parse($notice->publish_date)->format('F j, Y') }}
            </div>
        </div>

        <!-- Notice Title -->
        <div class="notice-title text-center mb-4">
            <h3 class="text-uppercase" style="border-bottom: 2px solid #000; display: inline-block; padding-bottom: 5px;">{{ $notice->title }}</h3>
        </div>

        <!-- Notice Body -->
        <div class="notice-body mb-4">
            <div class="salutation mb-3">
                <p>To whom it may concern,</p>
            </div>

            <div class="notice-content" style="text-align: justify; line-height: 1.8;">
                {!! nl2br(e($notice->description)) !!}
            </div>

            @if ($notice->meeting_date_time)
            <div class="meeting-details mt-4 p-3" style="background-color: #f8f9fa; border-left: 4px solid #007bff;">
                <h5>Meeting Details:</h5>
                <p class="mb-1"><strong>Date & Time:</strong> {{ \Carbon\Carbon::parse($notice->meeting_date_time)->format('l, F j, Y \a\t h:i A') }}</p>
                <p class="mb-0"><strong>Venue:</strong> [Specify meeting venue if available]</p>
            </div>
            @endif
        </div>

        <!-- Notice Footer -->
        <div class="notice-footer mt-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="notice-for">
                        <h5>Notice For:</h5>
                            @php
                            $noticeForNames = array_map(function ($value) use ($user_types) {
                                return $user_types[$value] ?? '';
                            }, json_decode($notice->notice_for));
                        @endphp
                        {!! implode(
                            array_map(function ($name) {
                                return '<span class="badge bg-primary me-1">' . e($name) . '</span>';
                            }, $noticeForNames),
                        ) !!}
                        </ul>
                    </div>
                    <div class="validity mt-3">
                        <p><strong>Valid Until:</strong> {{ \Carbon\Carbon::parse($notice->expire_date)->format('F j, Y') }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="signature-area float-end text-center" style="margin-top: 30px;">
                        <div style="margin-bottom: 60px; position: relative;">
                            <div style="border-top: 1px solid #000; width: 200px; margin-bottom: 5px;"></div>
                            <div class="text-muted">Authorized Signature</div>
                        </div>
                        <div>
                            <strong>[Authorized Person's Name]</strong><br>
                            <em>[Designation]</em><br>
                            <strong>{{$organization_info->company_name}}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .official-notice {
        background-color: #fff;
        padding: 40px;
        border: 1px solid #ddd;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        position: relative;
        max-width: 800px;
        margin: 30px auto;
    }

    .notice-header {
        border-bottom: 2px solid #000;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }

    .organization-logo h2 {
        color: #1a237e;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .organization-address {
        font-size: 14px;
        color: #555;
    }

    .notice-title h3 {
        font-weight: 600;
        color: #1a237e;
    }

    .notice-content {
        font-size: 16px;
        text-align: justify;
    }

    .signature-area {
        min-width: 250px;
    }

    @media print {
        body {
            background: none;
            padding: 0;
        }
        .official-notice {
            border: none;
            box-shadow: none;
            padding: 0;
        }
    }
</style>
@endsection --}}


@extends('setup.master')
@section('content')
    <div class="container-fluid py-5">
        <div class="official-notice">
            <!-- Letterhead/Header -->
            <div class="notice-header mb-4">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center text-md-start">
                        <div class="organization-logo">
                            <!-- Logo placeholder - could be replaced with an actual logo image -->
                            <div class="logo-placeholder">
                                <!-- Logo will be added here -->
                                {{-- <img src="{{ asset('path/to/your/logo.png') }}" alt="Organization Logo" class="img-fluid"> --}}
                                <img src="{{ asset('office/'.$organization_info->company_logo) }}" alt="Company Logo" class="img-fluid rounded" style="max-width: 100%; max-height: 100px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 text-center">
                        <h2 class="org-name">{{ $organization_info->company_name }}</h2>
                        <div class="org-details">
                            <p class="mb-0">{{ $organization_info->company_location }}</p>
                            <p class="mb-0">{{ $organization_info->company_phone }} |
                                {{ $organization_info->company_email }}</p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <!-- Space for additional header content if needed -->
                    </div>
                </div>
            </div>

            <!-- Reference and Date -->
            <div class="notice-meta d-flex justify-content-between mb-4">
                <div class="ref-no">
                    <span class="meta-label">Reference No:</span>
                    <span class="meta-value">{{ $notice->reference_no ?? 'N/A' }}</span>
                </div>
                <div class="notice-date">
                    <span class="meta-label">Date:</span>
                    <span class="meta-value">{{ \Carbon\Carbon::parse($notice->publish_date)->format('F j, Y') }}</span>
                </div>
            </div>

            <!-- Notice Title -->
            <div class="notice-title text-center mb-4">
                <h3>{{ $notice->title }}</h3>
                <div class="title-decoration"></div>
            </div>

            <!-- Notice Body -->
            <div class="notice-body mb-5">
                <div class="salutation mb-3">
                    <p>To whom it may concern,</p>
                </div>

                <div class="notice-content">
                    {!! nl2br(e($notice->description)) !!}
                </div>

                @if ($notice->meeting_date_time)
                    <div class="meeting-details mt-4">
                        <div class="meeting-header">
                            Meeting Details
                        </div>
                        <div class="meeting-content">
                            <div class="meeting-item">
                                <span class="meeting-label">Date & Time:</span>
                                <span
                                    class="meeting-value">{{ \Carbon\Carbon::parse($notice->meeting_date_time)->format('l, F j, Y \a\t h:i A') }}</span>
                            </div>
                            <div class="meeting-item">
                                <span class="meeting-label">Venue:</span>
                                <span class="meeting-value">{{ $notice->venue ?? '[Specify meeting venue]' }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <!-- Notice Details -->
            <div class="notice-details mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="notice-for">
                            <h5>Notice For:</h5>
                            <div class="target-audience">
                                @php
                                    $noticeForNames = array_map(function ($value) use ($user_types) {
                                        return $user_types[$value] ?? '';
                                    }, json_decode($notice->notice_for));
                                @endphp
                                @foreach ($noticeForNames as $name)
                                    <span class="audience-badge">{{ e($name) }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="validity">
                            <h5>Validity Period:</h5>
                            <p class="expiry-date">Valid until: <span
                                    class="validity-date">{{ \Carbon\Carbon::parse($notice->expire_date)->format('F d, Y') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notice Footer -->
            <div class="notice-footer mt-5">
                <div class="row">
                    <div class="col-md-7">
                    <!-- Additional footer information or disclaimers can go here -->
                    {{-- <div class="footer-info">
                        <p class="small text-muted mb-0">This is an official notice from {{$organization_info->company_name}}.</p>
                    </div> --}}
                </div>

                    {{-- <div class="col-md-5">
                    <div class="signature-area text-end">
                        <div class="signature-line"></div>
                        <div class="signatory">
                            <p class="signatory-title mb-0">Authorized Signature</p>
                            <p class="signatory-name mb-0"><strong>{{$notice->user->name}}</strong></p>
                            <p class="signatory-designation mb-0"><em>{{$notice->user->designation}}</em></p>
                            <p class="signatory-org mb-0">{{$organization_info->company_name}}</p>
                        </div>
                    </div>
                </div> --}}
                    <div class="col-md-5">
                        <div class="signature-area text-end">
                            @if ($notice->user->signature)
                                <img src="{{ asset('employee_signatures/' . $notice->user->signature) }}" alt="Signature"
                                    style="height: 60px;">
                            @endif
                            <div class="signature-line"></div>
                            <div class="signatory">
                                <p class="signatory-title mb-0">Authorized Signature</p>
                                <p class="signatory-name mb-0"><strong>{{ $notice->user->name }}</strong></p>
                                <p class="signatory-designation mb-0"><em>{{ $notice->user->designation }}</em></p>
                                <p class="signatory-org mb-0">{{ $organization_info->company_name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>

        /* Base Styles */
        .official-notice {
            background-color: #fff;
            padding: 40px 50px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            position: relative;
            max-width: 900px;
            margin: 0 auto;
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #333;
        }

        /* Header Styles */
        .notice-header {
            border-bottom: 2px solid #1a3a6c;
            padding-bottom: 20px;
        }

        .organization-logo {
            display: flex;
            justify-content: center;
        }

        .logo-placeholder {
            width: 100px;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            object-fit: contain;
            max-width: 100%;
        }

        .org-name {
            color: #1a3a6c;
            font-weight: 700;
            font-size: 28px;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .org-details {
            font-size: 14px;
            color: #555;
        }

        /* Meta Information */
        .notice-meta {
            padding: 15px 0;
            border-bottom: 1px solid #eaeaea;
        }

        .meta-label {
            font-weight: 600;
            color: #1a3a6c;
            margin-right: 8px;
        }

        .meta-value {
            font-weight: 500;
        }

        /* Title Styles */
        .notice-title {
            padding: 20px 0;
            position: relative;
        }

        .notice-title h3 {
            font-weight: 600;
            color: #1a3a6c;
            text-transform: uppercase;
            font-size: 22px;
            letter-spacing: 1px;
            display: inline-block;
            position: relative;
            margin-bottom: 10px;
        }

        .title-decoration {
            height: 3px;
            background-color: #1a3a6c;
            width: 150px;
            margin: 0 auto;
        }

        /* Content Styles */
        .notice-body {
            padding: 15px 0;
        }

        .salutation {
            font-weight: 500;
            font-size: 16px;
        }

        .notice-content {
            font-size: 16px;
            line-height: 1.8;
            text-align: justify;
        }

        /* Meeting Details */
        .meeting-details {
            background-color: #f8f9fa;
            border-left: 4px solid #1a3a6c;
            border-radius: 4px;
            overflow: hidden;
        }

        .meeting-header {
            background-color: #1a3a6c;
            color: white;
            padding: 10px 15px;
            font-weight: 600;
            font-size: 16px;
        }

        .meeting-content {
            padding: 15px;
        }

        .meeting-item {
            margin-bottom: 8px;
        }

        .meeting-label {
            font-weight: 600;
            color: #1a3a6c;
            margin-right: 8px;
            display: inline-block;
            width: 100px;
        }

        /* Notice Details */
        .notice-for h5,
        .validity h5 {
            color: #1a3a6c;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .target-audience {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .audience-badge {
            background-color: #1a3a6c;
            color: white;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 14px;
            display: inline-block;
        }

        .expiry-date {
            font-size: 15px;
        }

        .validity-date {
            color: #d32f2f;
            font-weight: 600;
        }

        /* Footer and Signature */
        .notice-footer {
            border-top: 1px solid #eaeaea;
            padding-top: 30px;
        }

        .footer-info {
            padding: 10px 0;
        }

        .signature-area {
            padding: 10px 30px;
            width: 250px;
            /* Fixed width for signature area */
            margin-left: auto;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            width: 100%;
            margin-bottom: 15px;
        }

        .signatory {
            text-align: center;
        }

        .signatory-title {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .signatory-name,
        .signatory-org {
            color: #1a3a6c;
        }

        .signatory-designation {
            font-size: 14px;
            color: #555;
        }

        /* Print Settings */
        @media print {
            body {
                background: none;
                padding: 0;
                margin: 0;
            }

            .container-fluid {
                padding: 0;
            }

            .official-notice {
                border: none;
                box-shadow: none;
                padding: 20px 0;
                max-width: 100%;
            }
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .official-notice {
                padding: 25px;
            }

            .notice-meta {
                flex-direction: column;
            }

            .notice-date {
                margin-top: 10px;
            }

            .signature-area {
                margin-top: 30px;
                text-align: center;
            }

            .signature-line {
                margin: 0 auto 15px;
            }
        }
    </style>
@endsection
