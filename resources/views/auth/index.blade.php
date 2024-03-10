<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('') }}modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('') }}modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('') }}modules/bootstrap-social/bootstrap-social.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('') }}css/style.css">
  <link rel="stylesheet" href="{{ asset('') }}css/components.css">
  <style>
    body {
      background-image: url('data:image/jpeg;base64,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'); /* Ganti 'path/to/your/image.jpg' dengan lokasi gambar Anda */
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }
  </style>
<!-- Start GA -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>
<!-- /END GA --></head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="{{ asset('img/logo.png') }}" alt="logo" width="100" class="">
            </div>
            @if (session()->has('message'))
                <div class="alert alert-danger">
                    {{session()->get('message')}}
                </div>
            @endif
            <div class="card card-primary">
              <div class="card-header"><h4>SILOR</h4></div>
              <div class="card-body">
                <form method="POST" action="{{route('login.post')}}" class="needs-validation" novalidate="">
                  @csrf
                  <div class="form-group">
                    <label for="email">Nim/Nip</label>
                    <input id="username" type="text" class="form-control" name="username" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Masukan Nim/Nip Saudara
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                    	<label for="password" class="control-label">Password</label>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                      Masukan Password Saudara
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="simple-footer text-white">
              Copyright &copy; Fakultas Kedokteran Gigi UNHAS 2018
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('') }}modules/jquery.min.js"></script>
  <script src="{{ asset('') }}modules/popper.js"></script>
  <script src="{{ asset('') }}modules/tooltip.js"></script>
  <script src="{{ asset('') }}modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="{{ asset('') }}modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="{{ asset('') }}modules/moment.min.js"></script>
  <script src="{{ asset('') }}js/stisla.js"></script>
  
  <!-- JS Libraies -->

  <!-- Page Specific JS File -->
  
  <!-- Template JS File -->
  <script src="{{ asset('') }}js/scripts.js"></script>
  <script src="{{ asset('') }}js/custom.js"></script>
</body>
</html>