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
  <section class="vh-100">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-8 px-0 d-none d-sm-block" style="background-image: url('{{asset('img/bg_login.jpg')}}'); background-size: cover; background-position: left; width: 100%; height: 100vh;">
      </div>
      <div class="col-sm-4 text-black">

        <div class="px-5 ms-xl-4">
          <center>
            <img src="{{asset('img/logo.png')}}" width="100" alt="" class="py-4">
          </center>
        </div>
        <h3 class="fw-small mb-3 pb-3 text-center" style="letter-spacing: 1px;">SILOR</h3>
        <h5 class="fw-small mb-3 pb-3 text-center" style="letter-spacing: 1px;">(Sistem Informasi LogBook Residen)</h5>
        @if (session()->has('message'))
            <div class="alert alert-danger">
                {{session()->get('message')}}
            </div>
        @endif
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{session()->get('success')}}
            </div>
        @endif
        <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-3 pt-5 pt-xl-0 mt-xl-n5">
          <form action="{{route('login.post')}}" style="width: 23rem;" method="POST">
            @csrf
            <div class="form-outline mb-4">
              <label class="form-label" for="username">Nim/Nip</label>
              <input type="text" name="username" id="username" class="form-control form-control-lg @error('username') is-invalid @enderror" />
              @error('username')
                  <span class="invalid-feedback">
                    {{$message}}
                  </span>
              @enderror
            </div>

            <div class="form-outline mb-4">
              <label class="form-label" for="password">Password</label>
              <input type="password" name="password" id="password" class="form-control form-control-lg @error('password') is-invalid @enderror"/>
              @error('password')
                  <span class="invalid-feedback">
                    {{$message}}
                  </span>
              @enderror
            </div>

            <div class="pt-1 mb-4">
              <button class="btn btn-lg btn-block" type="submit" style="background-color: #f4bb6c; color: #fff">Login</button>
            </div> 

            <p class="small mb-5 pb-lg-2"><a class="text-muted" href="#!"></a></p>
            <p>Copyrigth &copy; Fakultas Kedokteran Gigi UNHAS {{ date('Y') }}</p>

          </form>

        </div>

      </div>
    </div>
  </div>
</section>

  <!-- General JS Scripts -->
  <script src="{{ asset('') }}modules/jquery.min.js"></script>
  <script src="{{ asset('') }}modules/popper.js"></script>
  <script src="{{ asset('') }}modules/tooltip.js"></script>
  <script src="{{ asset('') }}modules/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>