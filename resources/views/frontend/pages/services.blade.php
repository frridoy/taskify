@extends('frontend.master')
@section('content')




 <div class="services section" id="services">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6">
          <div class="service-item">
            <div class="icon">
              <img src="{{asset('frontend/assets/images/service-01.png')}}" alt="online degrees">
            </div>
            <div class="main-content">
              <h4>Online Degrees</h4>
              <p>Whenever you need free templates in HTML CSS, you just remember TemplateMo website.</p>
              <div class="main-button">
                <a href="#">Read More</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="service-item">
            <div class="icon">
              <img src="{{asset('frontend/assets/images/service-02.png')}}" alt="short courses">
            </div>
            <div class="main-content">
              <h4>Short Courses</h4>
              <p>You can browse free templates based on different tags such as digital marketing, etc.</p>
              <div class="main-button">
                <a href="#">Read More</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="service-item">
            <div class="icon">
              <img src="{{asset('frontend/assets/images/service-03.png')}}" alt="web experts">
            </div>
            <div class="main-content">
              <h4>Web Experts</h4>
              <p>You can start learning HTML CSS by modifying free templates from our website too.</p>
              <div class="main-button">
                <a href="#">Read More</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>








@endsection
