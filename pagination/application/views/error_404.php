<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>404 Page Not Found</title>

        <link rel="stylesheet" href="<?= base_url() ?>/assets/error_404.css" />
    </head>
    <body>
        <h1> ERROR 404 </h1>

        <h4> Ooops!! Page not Found. </h4>

        <br>
        <p class="center italic">Single player game</p>
        <p class="center">Let's see what you've got. Click on a space below to begin playing.
            <br>Good luck!</p>
        <br>
        <br>
        <div id="board-outer" class="center">
            <table id="board">
                <tr class="row">
                    <td id="a1"></td>
                    <td id="a2"></td>
                    <td id="a3"></td>
                </tr>
                <tr class="row">
                    <td id="b1"></td>
                    <td id="b2"></td>
                    <td id="b3"></td>
                </tr>
                <tr class="row">
                    <td id="c1"></td>
                    <td id="c2"></td>
                    <td id="c3"></td>
                </tr>
            </table>
        </div>
        <br>
        <br>
        <br>
        <div class="center button">
            <button id="restart">New game</button>
        </div>
    </body>
    <script src="https://code.jquery.com/jquery-1.9.1.js" integrity="sha256-e9gNBsAcA0DBuRWbm0oZfbiCyhjLrI6bmqAl5o+ZjUA=" crossorigin="anonymous"></script>
    <script src="<?=  base_url()?>/assets/tictactoe.js"></script>
</html>