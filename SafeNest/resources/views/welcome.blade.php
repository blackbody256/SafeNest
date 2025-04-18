<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>
  <!-- Font Awesome Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- CSS Link -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
  <!-- Header Section -->
  <header>
    <input type="checkbox" id="toggler">
    <label for="toggler" class="fas fa-bars"></label>
    <a href="#" class="logo">SafeNest<span>.</span></a>
    <nav class="navbar">
      <a href="#home">Home</a>
      <a href="#about">About</a>
      <a href="#policies">Policies</a>
      <a href="#contact">Contact</a>
      <a href="{{ route('login') }}" class="nav-link nav-item {{ Route::is('login') ? 'active' : '' }}">
        <i class="nc-icon nc-mobile"></i> {{ __('Login') }}
      </a>


    </nav>
  </header>

  <!-- Home Section -->
  <section class="home" id="home">
    <div class="content">
      <h3><span>Insurance</span>partner</h3>
      <a href="{{ route('register') }}" class="btn {{ Route::is('register') ? 'active' : '' }}">
        <i class="nc-icon nc-badge"></i> {{ __('Register Now') }}
      </a>

    </div>
  </section>

  <!-- About Section -->
  <section class="about" id="about">
    <h1 class="heading"><span>about</span>us</h1>
    <div class="row">
      <div class="video-container">
        <video src="{{ asset('videos/baby.mp4') }}" loop autoplay muted></video>
        <h3>Secure Today,Safe Tomorrow</h3>
      </div>
      <div class="content">
        <h3>Our Promise To You!</h3>
        <p>With over 10 years of experience in the insurance industry,we are dedicated to putting your needs first with customized cover options. We offer online application with Quick claims processing within 48hours.</p>
        <p>We offer competitive packages,no hidden fees or complex jargon, 24/7 customer support and emergency assistance.We are regulated and licensed by the Insurance Regulatory Authority.</p>
      </div>
    </div>
  </section>

  <!-- Icons Section -->
  <section class="icons-container">
    <div class="icons">
      <img src="{{ asset('images/bill.png') }}" alt="">
      <div class="info">
        <h3>Legal Contracts</h3>
        <span>for all policies</span>
      </div>
    </div>

    <div class="icons">
      <img src=" {{ asset('images/salary.png') }}" alt="">
      <div class="info">
        <h3>Cash out on claims</h3>
        <span>full payment guarantee</span>
      </div>
    </div>

    <div class="icons">
      <img src=" {{ asset('images/card-security.png') }}" alt="">
      <div class="info">
        <h3>Secure payments</h3>
        <span>protected by paypal</span>
      </div>
    </div>
  </section>

  <!--Policies section-->
  <section class="policies" id="policies">
    <h1 class="heading">Standard<span>policies</span></h1>

    <div class="box-container">
        <div class="box">
            <div class="image">
                <img src=" {{ asset('images/hands-1850223_1280.jpg') }}" alt="">
            </div>

            <div class="content">
                <h3>Life plan</h3>
                <p>Secure your loved ones’ future with our Life Plan. This policy provides financial protection and peace of mind, ensuring your family is well-supported in the event of life’s uncertainties. It's more than insurance — it’s a lasting legacy of care.</p>

            </div>
        </div>

        <div class="box">
            <div class="image">
                <img src=" {{ asset('images/kindergarten-graduation-7257180_1280.jpg') }}" alt="">
            </div>

            <div class="content">
                <h3>Education plan</h3>
                <p>Give your child the education they deserve with our flexible Education Plan. This savings policy is designed to help parents and guardians build a solid financial foundation for future school fees, college expenses, and more — because every child deserves a bright tomorrow.</p>

            </div>
        </div>

        <div class="box">
            <div class="image">
                <img src="{{ asset('images/diaspora.jpg ') }}" alt="">
            </div>

            <div class="content">
                <h3>Diaspora plan</h3>
                <p>Working abroad? Our Diaspora Savings Plan makes it easy for you to grow your savings back home while you focus on your career. With secure, goal-oriented options and flexible contributions, you can plan confidently for your future, wherever you are in the world.</p>

            </div>
        </div>
        <a href="#" class="btn">view customized policies</a>

    </div>
  </section>    


  <!--Contact section-->
  <section class="contact" id="contact">
    <h1 class="heading"><span>Contact</span>us</h1>

    <div class="row">

<!--success message for sending message.-->
    @if(session('success'))
        <script>
            window.onload = function() {
                alert("{{ session('success') }}");
            };
        </script>
    @endif


        <form action="{{ route('contact.send') }}" method="POST">
            @csrf
            <input type="text" name="name" placeholder="name" class="box">
            <input type="email" name="email" placeholder="email" class="box">
            <input type="tel" name="phone" class="box"  placeholder="phone number"  pattern="[0-9+ ]+">
            <textarea name="message" id="" class="box" placeholder="message" cols="30" rows="10"></textarea>
            <input type="submit" value="send" class="btn">
        </form>

        <div class="image">
            <img src=" {{ asset('images/birds-nest-2121590_1920.jpg') }}" alt="">
        </div>
    </div>

  </section>


</body>
</html>
