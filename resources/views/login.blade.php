<!DOCTYPE html>
<html lang="en">
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Streamviewer</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="/css/app.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">
    <link type="text/css" rel="stylesheet" href="//unpkg.com/bootstrap/dist/css/bootstrap.min.css"/>
    <link type="text/css" rel="stylesheet" href="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.css"/>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <style>
        /* Taken from a tutorial from my previous Elixir implementation. */
        .hero-section {
            background: linear-gradient(
            rgba(0, 0, 0, 0.3),
            rgba(0, 0, 0, 0.2)
            ), url('data:image/png;base64,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') 10% no-repeat;
            background-size: cover;
            height: 80vh;
            text-align: center;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
        }
        .hero-section .hero-section-text {
            color: #fefefe;
            text-shadow: 1px 1px 2px #0a0a0a;
        }
        .no-js .top-bar {
            display: none;
        }
        @media screen and (min-width: 40em) {
            .no-js .top-bar {
                display: block;
            }
            .no-js .title-bar {
                display: none;
            }
        }
        .cta-text {
            font-size: 2.5em;
        }
    </style>
    </head>
    <body>
    <div id="app">
        
        <div class="title-bar" data-responsive-toggle="my-menu" data-hide-for="medium">
            <button class="menu-icon" type="button" data-toggle="my-menu"></button>
            <div class="title-bar-title">Menu</div>
        </div>
        <div class="top-bar" id="my-menu">
            <div class="top-bar-left">
                <ul class="menu">
                    <li class="menu-text">Streamviewer</li>
                </ul>
            </div>
            <div class="top-bar-right">
                <ul class="menu">
                    <li>
                        <a class="btn btn-primary" href="/login/google#">Sign in with Google</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="hero-section">
            <div class="hero-section-text">
                <p class="cta-text">
                    Welcome to Streamviewer! A service that finds the hottest live streams on YouTube and lets you participate.
                </p>
                <a class="btn btn-primary" href="/login/google/">Login with Google</a>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="js/app.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/babel-polyfill@latest/dist/polyfill.min.js"></script>
    <script src="https://unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.js"></script>
    <script type='text/javascript'>
         window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

     <script defer src="https://use.fontawesome.com/releases/v5.0.0/js/all.js"></script>
    
    </body>
</html>