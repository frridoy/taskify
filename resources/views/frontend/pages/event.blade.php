@extends('frontend.master')
@section('content')


  <div class="section events" id="events">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <div class="section-heading">
            <h6>Schedule</h6>
            <h2>Upcoming Events</h2>
          </div>
        </div>
        <div class="col-lg-12 col-md-6">
          <div class="item">
            <div class="row">
              <div class="col-lg-3">
                <div class="image">
                  <img src="{{asset('frontend/assets/images/event-01.jpg')}}" alt="">
                </div>
              </div>
              <div class="col-lg-9">
                <ul>
                  <li>
                    <span class="category">Web Design</span>
                    <h4>UI Best Practices</h4>
                  </li>
                  <li>
                    <span>Date:</span>
                    <h6>16 Feb 2036</h6>
                  </li>
                  <li>
                    <span>Duration:</span>
                    <h6>22 Hours</h6>
                  </li>
                  <li>
                    <span>Price:</span>
                    <h6>$120</h6>
                  </li>
                </ul>
                <a href="#"><i class="fa fa-angle-right"></i></a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12 col-md-6">
          <div class="item">
            <div class="row">
              <div class="col-lg-3">
                <div class="image">
                  <img src="{{asset('frontend/assets/images/event-02.jpg')}}" alt="">
                </div>
              </div>
              <div class="col-lg-9">
                <ul>
                  <li>
                    <span class="category">Front End</span>
                    <h4>New Design Trend</h4>
                  </li>
                  <li>
                    <span>Date:</span>
                    <h6>24 Feb 2036</h6>
                  </li>
                  <li>
                    <span>Duration:</span>
                    <h6>30 Hours</h6>
                  </li>
                  <li>
                    <span>Price:</span>
                    <h6>$320</h6>
                  </li>
                </ul>
                <a href="#"><i class="fa fa-angle-right"></i></a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12 col-md-6">
          <div class="item">
            <div class="row">
              <div class="col-lg-3">
                <div class="image">
                  <img src="{{asset('frontend/assets/images/event-03.jpg')}}" alt="">
                </div>
              </div>
              <div class="col-lg-9">
                <ul>
                  <li>
                    <span class="category">Full Stack</span>
                    <h4>Web Programming</h4>
                  </li>
                  <li>
                    <span>Date:</span>
                    <h6>12 Mar 2036</h6>
                  </li>
                  <li>
                    <span>Duration:</span>
                    <h6>48 Hours</h6>
                  </li>
                  <li>
                    <span>Price:</span>
                    <h6>$440</h6>
                  </li>
                </ul>
                <a href="#"><i class="fa fa-angle-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @endsection
