<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>10進数⇔2進数計算</title>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css"
          integrity="sha256-UzFD2WYH2U1dQpKDjjZK72VtPeWP50NoJjd26rnAdUI=" crossorigin="anonymous"/>
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.bundle.min.js"
            integrity="sha384-zDnhMsjVZfS3hiP7oCBRmfjkQC4fzxVxFhBx8Hkz2aZX8gEvA/jsP3eXRCvzTofP"
            crossorigin="anonymous"></script>
    <script>
        $(function () {
            let $n10 = $('#n10');
            let $n2s = $('.n2:input');

            let $log = $('#log');
            let $btn_to2 = $('#btn-to2');
            let $btn_to10 = $('#btn-to10');

            /**
             * 10進数入力
             */
            $n10.on('change', function () {
                let $self = $(this);
                $self.val($self.val().replace(/[^0123456789]/g, ''));
            });
            /**
             * 10進数 -> 2進数計算
             */
            $btn_to2.on('click', function () {
                $log.html(''); // ログ初期化
                $n2s.val(0); // 2進数入力欄初期化
                if ($n10.val() === '') {
                    $n10.val(0); // 10進数入力欄が空なら0を入力
                }
                let num = parseInt($n10.val(), 10);
                $log.append('<tr><td colspan="4">整数部計算</td></tr>');
                $log.append('<tr><td>2</td><td class="lb-border"><strong>' + num + '</strong></td><td></td><td></td></tr>');
                while (num > 0) {
                    let mod = num % 2;
                    num = Math.floor(num / 2);
                    if (num === 0) {
                        let $add_tr = $('<tr><td></td><td>' + num + '</td><td>...</td><td class="mod">' + mod + '</td></tr>').hide();
                        $add_tr.appendTo($log).fadeIn();
                    } else {
                        let $add_tr = $('<tr><td>2</td><td class="lb-border">' + num + '</td><td>...</td><td class="mod">' + mod + '</td></tr>').hide();
                        $add_tr.appendTo($log).fadeIn();
                    }
                }
                let index = 0;
                $log.find('.mod').each(function () {
                    $(this).after('<td> -> </td><td>2<sup>' + index + '</sup></td>');
                    $('#n2-' + index).val($(this).text());
                    index++;
                });
            });

            /**
             * 2進数入力
             */
            $n2s.on('focus', function () {
                this.select();
            }).on('keyup', function (event) {
                let $self = $(this);
                let code = event.keyCode;
                if (code === 48 || code === 49) {
                    let nextIndex = $n2s.index(this) + 1;
                    if (nextIndex < $n2s.length) {
                        $n2s.get(nextIndex).focus();
                    }
                } else {
                    $self.val(0);
                    this.select();
                    return false;
                }
            });
            /**
             * 2進数 -> 10進数計算
             */
            $btn_to10.on('click', function () {
                $log.html(''); // ログ初期化
                let n10 = 0;
                $n2s.each(function () {
                    let $self = $(this);
                    if ($self.val() === "1") {
                        let power = parseInt($self.attr('data-power'), 10);
                        let add = Math.pow(2, power);
                        n10 += add;
                        $log.append('<tr><td> + </td><td>2<sup>' + power + '</sup></td><td> ... </td><td>' + add + '</td></tr>');
                    }
                });
                $n10.val(n10);
            });
        });
    </script>
    <style>
        input[type="text"] {
            font-family: monospace;
            font-size: 2em;
        }

        #log-panel {
            padding: 10px;
            background: #eee;
        }

        .log-table td {
            padding: 1px 3px 1px 3px;
            margin: 1px;
        }

        td.lb-border {
            border-left: 1px solid #888;
            border-bottom: 1px solid #888;
        }

        #n10 {
            font-size: 3em;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark mb-2">
    <a class="navbar-brand" href="#">
        <i class="fa fa-calculator"></i> 10進数⇔2進数計算
    </a>
</nav>

<div class="container-fluid">
    <div class="col-md-12">
        <h2>10進数</h2>
        <label class="input-group mb-3">
            <input type="text" id="n10" name="n10" class="form-control form-control-lg" placeholder="65,535までの整数を入力">
        </label>
        <div class="text-center">
            <button id="btn-to2" class="btn btn-lg btn-primary"><i class="fa fa-arrow-alt-circle-down"></i> 2進数へ変換
            </button>
            <button id="btn-to10" class="btn btn-lg btn-danger"><i class="fa fa-arrow-alt-circle-up"></i> 10進数へ変換
            </button>
        </div>
        <h2>2進数</h2>
        <div class="input-group mb-3">
            <table>
                <tr>
                    <?php for ($i = 15; $i >= 0; $i--): ?>
                        <td style="<?= $i % 4 == 0 ? 'border-right:1px solid #aaa;' : '' ?>">
                            <div class="text-center">
                                2<sup><?= $i ?></sup>
                            </div>
                            <label>
                                <input type="text"
                                       id="n2-<?= $i ?>"
                                       name="n2-<?= $i ?>"
                                       data-power="<?= $i ?>"
                                       value="0"
                                       class="n2 form-control text-center"
                                       maxlength="1">
                            </label>
                        </td>
                    <? endfor; ?>
                </tr>
            </table>
        </div>
        <h2>計算手順</h2>
        <div id="log-panel">
            <table id="log" class="log-table"></table>
        </div>
    </div>
</div>
</body>
</html>
