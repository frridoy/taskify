@extends('frontend.master')
@section('content')
<div class="contact-us section" id="contact">
    <div class="container">
      <div class="row">
        <div class="col-lg-6  align-self-center">
          <div class="section-heading">
            <h6>Contact Us</h6>
            <h2>Feel free to contact us anytime</h2>
            <p>Thank you for choosing our templates. We provide you best CSS templates at absolutely 100% free of charge. You may support us by sharing our website to your friends.</p>
            <div class="special-offer">
              <span class="offer">off<br><em>50%</em></span>
              <h6>Valide: <em>24 April 2036</em></h6>
              <h4>Special Offer <em>50%</em> OFF!</h4>
              <a href="#"><i class="fa fa-angle-right"></i></a>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="contact-us-content">
            <form id="contact-form" action="" method="post">
              <div class="row">
                <div class="col-lg-12">
                  <fieldset>
                    <input type="name" name="name" id="name" placeholder="Your Name..." autocomplete="on" required>
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <input type="text" name="email" id="email" pattern="[^ @]*@[^ @]*" placeholder="Your E-mail..." required="">
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <textarea name="message" id="message" placeholder="Your Message"></textarea>
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <button type="submit" id="form-submit" class="orange-button">Send Message Now</button>
                  </fieldset>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  @endsection
