{{-- ------------------------------------------------------------------------------------------------------------------------------------ --}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Komunikator</title>


    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cssfix.css') }}">
  </head>
  <body>

    <header>
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-blue">
        <div class=" navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">Logowanie</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('register') }}" class="nav-link">Rejestracja</a>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <main role="main">

      <div id="myCarousel" class="carousel slide" data-ride="carousel">

      </div>


      <!-- Marketing messaging and featurettes
      ================================================== -->
      <!-- Wrap the rest of the page in another container to center all the content. -->

      <div class="container marketing">

        <!-- Three columns of text below the carousel -->
        <div class="row">
          <div class="col-lg-4">
            <img class="rounded-circle" src="/uploads/img/platon.jpg" alt="Generic placeholder image" width="140" height="140">
            <h2>Platon</h2>
            <p>"Przecież kto wtedy zacznie kochać, ten, zdaje mi się, gotów będzie pójść z drugim przez całe życie, a nie - wyzyskać młodzieńczą lekkomyślność, wyśmiać, rzucić i gonić za innymi." <br>Używam codziennie.</p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <img class="rounded-circle" src="/uploads/img/arystoteles.jpg" alt="Generic placeholder image" width="140" height="140">
            <h2>Arystoteles</h2>
            <p>"W miarę możności należy unikać błędów."<br>Aplikacja bezawaryjna polecam każdemu!</p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <img class="rounded-circle" src="/uploads/img/pitagoras.jpg" alt="Generic placeholder image" width="140" height="140">
            <h2>Pitagoras</h2>
            <p>"Musisz sam sobie zaufać, aby zaufali ci inni." <br> Szyfrowanie w tej aplikacji zapewnia bezpieczną komunikację.</p>
          </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->


        <!-- START THE FEATURETTES -->

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">Pierwszy komunikator przyjazny młodzieży.</h2>
            <p class="lead">Komunikator to pierwsza na świecie oraz wiodąca aplikacja filtrująca słowa wulgarne. Dzięki zaawansowanej technologii jest w stanie wykryć oraz zamienić wulgaryzym na słowa przyjazne. Dzięki tym aspektom jest polecana dzieciom oraz młodzieży przez znamienitych Greckich mędrców.</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" src="/uploads/img/zamiana.PNG" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading">Bezpłatna komunikacja</h2>
            <p class="lead">Komunikator to niezależna grupa non-profit. Nie jesteśmy związani z żadną z dużych firm technologicznych. Nasza praca jest motywowana przez chęć dostania 5.0 z Baz Danych.</p>
          </div>
          <div class="col-md-5 order-md-1">
            <img class="featurette-image img-fluid mx-auto" src="/uploads/img/nonprofit.jpg" alt="WiP">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">Pomoc</h2>
            <p class="lead">Dodawanie znajomych</p>
            <ul>
                <li>Po zalogowaniu wyświetli się panel główny</li>
                <li>Klikamy zakładkę Wysłane</li>
                <li>Aby dodać znajomego musimy znać jego email</li>
                <li>Po wysłaniu zaproszenia należy zaczekać na akceptacje</li>
            </ul>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" data-src="/uploads/img/pomoc.png" src="/uploads/img/pomoc.png" alt="pomoc">
          </div>
        </div>

        <hr class="featurette-divider">

        <!-- /END THE FEATURETTES -->

      </div><!-- /.container -->


      <!-- FOOTER -->
      <footer class="container">
        <p class="float-right"><a href="#">Powrót na górę</a></p>
      </footer>
    </main>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../../assets/js/vendor/holder.min.js"></script>
  </body>
</html>
