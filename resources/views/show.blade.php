@extends('layouts.app')

@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-10 col-sm-12">
                <div class="text-center">
                    <img src='storage/{{ $result->avatar }}' alt="Profile photo" class="single-profile_photo rounded-circle mb-4" />
                    <h4>{{ $result->name }}</h4>

                    <span class="alert alert-success p-1">{{ $result->type === 'org' ? 'Organisation' : 'Church'  }}</span> &nbsp;
                    <span class="alert alert-primary p-1">{{ $result->type === 'org' ? $result->denomination_id : $result->denomination  }}</span>
                </div>

                <div class="row justify-content-center pt-5">
                    <div class="col-lg-8 col-md-10 col-sm-12">
                        @if($result->mission !== null)
                        <p class="single-bg p-4 rounded-3">
                            <span class="fw-bold">Mission:</span> <br />
                            <span class="fst-italic">
                                {{ $result->mission === null ? 'N/A' : $result->mission  }}
                            </span>
                        </p>
                        @endif
                        @if($result->vision !== null)
                        <p class="single-bg p-4 rounded-3">
                            <span class="fw-bold">Vision:</span> <br />
                            <span class="fst-italic">
                                {{ $result->vision === null ? 'N/A' : $result->vision  }}
                            </span>
                        </p>
                        @endif
                    </div>

                    <br />

                    <div class="col-lg-8 col-md-10 col-sm-12">
                        <page-component record_id="{{ $result->id }}" recordtype="{{ $result->type }}"></page-component> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-dark mt-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-8 footer_alignment">
                        <img src="images/nccs_logo_bw.png" class="footer_bw_logo mb-3" />
                        <p class="text-white about_text">
                            Lorem ipsum dolor Lorem ipsum dolorLorem ipsum dolorLorem ipsum dolorLorem ipsum dolorLorem ipsum dolorLorem ipsum dolor
                        </p>
                        <p>
                            <a class="text-white footer_left_link" href="#">Disclaimer</a> <span class="text-white mx-2">|</span> <a class="text-white footer_left_link" href="#">Private Policy</a>
                        </p>
                    </div>
                    <div class="col-md-4 footer_alignment">
                        <p class="text-white fw-bold mb-1">For listing inquiry, contact us:</p>
                        <ul class="list-group list-unstyled">
                            <li>
                                <p class="text-white mt-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="footer_icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    (63) 1234-5678
                                </p>
                            </li>
                            <li>
                                <p class="text-white contactNumber">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="footer_icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>   
                                    1234-5678
                                </p>
                            </li>
                            <li>
                                <p class="text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="footer_icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>    
                                    test@email.com
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
