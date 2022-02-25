<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Meu Campeonato</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <style>
        .header {
            max-width: 700px;
        }
    </style>
</head>

<body class="antialiased">
<div class="header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <h1 class="display-4">Meu Campeonato</h1>
    <p class="lead">Simples API desenvolvida com php utilizando o framework Laravel 8 para o processo de recrutamento Trade.</p>
</div>
<div class="container">
    <div class="row">
        <div class="col-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Times</h4>
                </div>
                <table class="table table-condensed table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>Sigla</th>
                </tr>
                </thead>
                <tbody>
                @foreach($times as $time)
                    <tr>
                        <td>{{ $time->id }}</td>
                        <td>{{ $time->nome }}</td>
                        <td>{{ $time->sigla }}</td>
                    </tr>
                @endforeach
                </tbody>
                </table>
            </div>
        </div>
        <div class="col-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Campeonatos</h4>
                </div>
                <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Campeão</th>
                        <th>Vice</th>
                        <th>Terceiro</th>
                    </tr>
                <tbody>
                @foreach($campeonatos as $campeonato)
                    <tr style="background: #dee2e6;">
                        <td>{{ $campeonato['id'] }}</td>
                        <td>{{ $campeonato['nome'] }}</td>
                        <td>{{ $campeonato['campeao'] }}</td>
                        <td>{{ $campeonato['vice'] }}</td>
                        <td>{{ $campeonato['terceiro'] }}</td>
                    </tr>
                    <tr>
                        <td colspan="5" style="padding: 0;">
                            <table class="table  table-hover table-condensed">
                            @forelse($campeonato['jogos'] as $jogo)
                                <tr>
                                    <td>{{ $jogo['fase'] }}</td>
                                    <td>{{ $jogo['time_casa'] }}</td>
                                    <td>{{ $jogo['placar_time_casa'] }}</td>
                                    <th>X</th>
                                    <td>{{ $jogo['placar_time_fora'] }}</td>
                                    <td>{{ $jogo['time_fora'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td align="center">Nenhum jogo realizado</td>
                                </tr>
                            @endforelse
                            </table>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
        <div class="row">
          <div class="col-4"><h2>Créditos</h2></div>
          <div class="col-8">Wesley Maciel Barbosa<br>Email: wesleym.barbosa@gmail.com<br>Fone/Whatsapp: (44) 99960-4188</div>
    </footer>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</body>
</html>
